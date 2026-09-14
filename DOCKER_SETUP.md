# Docker 安装和启动指南

## 第一步：安装 Docker Desktop

### Windows 安装步骤：

1. **下载 Docker Desktop**
   - 访问官网：https://www.docker.com/products/docker-desktop
   - 点击 "Download for Windows" 按钮
   - 下载完成后会得到 `Docker Desktop Installer.exe` 文件

2. **系统要求**
   - Windows 10 64-bit: Pro, Enterprise, 或 Education (Build 19041 或更高)
   - 或 Windows 11
   - 启用 WSL 2 功能
   - 启用虚拟化功能（在 BIOS 中）

3. **安装 Docker Desktop**
   - 双击运行 `Docker Desktop Installer.exe`
   - 勾选 "Use WSL 2 instead of Hyper-V" 选项（推荐）
   - 按照安装向导完成安装
   - 安装完成后，**重启计算机**

4. **启动 Docker Desktop**
   - 重启后，从开始菜单启动 "Docker Desktop"
   - 首次启动可能需要几分钟
   - 等待右下角系统托盘中的 Docker 图标变为绿色
   - 如果提示安装 WSL 2，请按照提示完成安装

5. **验证安装**
   - 打开新的 PowerShell 窗口
   - 运行以下命令：
   ```powershell
   docker --version
   docker-compose --version
   ```
   - 如果显示版本号，说明安装成功

## 第二步：启动 FlowerShop 项目

### 1. 创建环境配置文件

在项目根目录运行：
```powershell
# 复制环境配置文件
Copy-Item .env.example .env
```

### 2. 生成 Laravel 应用密钥

编辑 `.env` 文件，或者等待 Docker 启动时自动生成。

### 3. 启动 Docker 容器

在项目根目录运行：
```powershell
# 构建并启动所有容器
docker-compose up -d --build
```

这个命令会：
- 构建 Laravel 应用的 Docker 镜像（包含前端和后端）
- 启动 MySQL 数据库容器
- 自动运行数据库迁移
- 链接存储目录

### 4. 查看容器状态

```powershell
# 查看运行中的容器
docker-compose ps

# 查看容器日志
docker-compose logs -f app
```

### 5. 访问应用

- **前端网站**: http://localhost:8080
- **数据库**: localhost:3307 (用户名: flowershop, 密码: flowershop)

## 常用命令

### 启动和停止

```powershell
# 启动容器（后台运行）
docker-compose up -d

# 停止容器
docker-compose stop

# 停止并删除容器
docker-compose down

# 停止并删除容器及数据卷（慎用！会删除数据库数据）
docker-compose down -v
```

### 查看日志

```powershell
# 查看所有容器日志
docker-compose logs

# 实时查看应用日志
docker-compose logs -f app

# 实时查看数据库日志
docker-compose logs -f db
```

### 进入容器

```powershell
# 进入应用容器
docker-compose exec app bash

# 进入数据库容器
docker-compose exec db bash
```

### 运行 Laravel 命令

```powershell
# 运行 Artisan 命令
docker-compose exec app php artisan migrate

# 清除缓存
docker-compose exec app php artisan cache:clear

# 查看路由列表
docker-compose exec app php artisan route:list
```

### 重新构建

```powershell
# 重新构建镜像（代码更新后）
docker-compose up -d --build

# 强制重新构建（无缓存）
docker-compose build --no-cache
```

## 故障排查

### 问题1：端口被占用

如果 8080 或 3307 端口被占用，修改 `docker-compose.yml`：

```yaml
ports:
  - "8081:80"  # 改为其他端口
```

### 问题2：容器启动失败

```powershell
# 查看详细日志
docker-compose logs app

# 重启容器
docker-compose restart app
```

### 问题3：数据库连接失败

```powershell
# 等待数据库完全启动
docker-compose logs db

# 手动运行迁移
docker-compose exec app php artisan migrate
```

### 问题4：前端资源未更新

```powershell
# 重新构建镜像
docker-compose build --no-cache app
docker-compose up -d
```

### 问题5：清理所有 Docker 资源

```powershell
# 停止并删除所有容器
docker-compose down

# 清理未使用的镜像
docker image prune -a

# 清理未使用的卷
docker volume prune
```

## 开发模式 vs 生产模式

当前配置是开发模式，特点：
- 开启调试模式
- 实时代码同步（通过 volumes）
- 详细错误信息

生产模式需要修改：
- 设置 `APP_DEBUG=false`
- 移除代码卷挂载
- 使用优化的构建

## 项目架构

```
FlowerShop
├── Dockerfile              # 应用容器定义
├── docker-compose.yml      # 多容器编排配置
├── docker/
│   ├── apache-vhost.conf  # Apache 虚拟主机配置
│   └── entrypoint.sh      # 容器启动脚本
├── app/                    # Laravel 后端代码
├── resources/              # 前端资源（Blade 模板、CSS、JS）
├── public/                 # 公共资源
└── database/               # 数据库迁移和填充
```

## 下一步

安装完 Docker 后，请重新打开终端窗口并运行：

```powershell
cd C:\Users\hungh\OneDrive\Documents\GitHub\FlowerShop
Copy-Item .env.example .env
docker-compose up -d --build
```

然后访问 http://localhost:8080 查看你的网站！
