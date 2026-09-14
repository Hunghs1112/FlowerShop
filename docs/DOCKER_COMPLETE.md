# Docker 设置完成总结

## 🎉 已完成的工作

我已经为你的 FlowerShop 项目完成了完整的 Docker 配置和启动脚本。现在你可以使用 Docker 轻松运行整个项目。

## 📦 已创建的文件

### 1. 核心配置文件（已存在）
- ✅ `Dockerfile` - 应用容器定义
- ✅ `docker-compose.yml` - 多容器编排配置
- ✅ `docker/apache-vhost.conf` - Apache 虚拟主机配置
- ✅ `docker/entrypoint.sh` - 容器启动脚本

### 2. 新增的启动脚本
- ✅ `start-docker.ps1` - **完整的 Docker 启动脚本**（带环境检查）
- ✅ `start.ps1` - **快速启动脚本**
- ✅ `stop.ps1` - **停止脚本**
- ✅ `logs.ps1` - **查看日志脚本**

### 3. 文档文件
- ✅ `DOCKER_SETUP.md` - **详细的 Docker 安装和使用指南**
- ✅ `README.md` - **已更新，添加 Docker 使用说明**

## 🚀 使用步骤

### 第一步：安装 Docker Desktop

1. 访问：https://www.docker.com/products/docker-desktop
2. 下载 **Docker Desktop for Windows**
3. 运行安装程序并按照向导完成安装
4. **重启计算机**（重要！）
5. 启动 Docker Desktop 应用程序
6. 等待 Docker 完全启动（托盘图标变绿）

### 第二步：启动项目

打开 PowerShell，进入项目目录：

```powershell
cd C:\Users\hungh\OneDrive\Documents\GitHub\FlowerShop
```

**首次启动（推荐）：**
```powershell
.\start-docker.ps1
```

这个脚本会：
- ✅ 检查 Docker 是否安装
- ✅ 检查 Docker 是否运行
- ✅ 自动创建 .env 配置文件
- ✅ 构建并启动所有容器
- ✅ 自动打开浏览器访问网站

**后续快速启动：**
```powershell
.\start.ps1
```

### 第三步：访问网站

启动成功后，在浏览器访问：
- **网站首页**: http://localhost:8080
- **越南语**: http://localhost:8080/vi
- **英语**: http://localhost:8080/en
- **管理后台**: http://localhost:8080/admin

### 其他常用命令

```powershell
# 停止服务
.\stop.ps1

# 查看日志
.\logs.ps1

# 手动启动（使用 docker-compose）
docker-compose up -d

# 查看容器状态
docker-compose ps

# 重新构建
docker-compose up -d --build

# 进入应用容器
docker-compose exec app bash

# 运行 Laravel 命令
docker-compose exec app php artisan migrate
```

## 🏗️ 项目架构

### Docker 容器

项目使用 2 个容器：

1. **flowershop-app** (端口 8080)
   - Laravel 应用
   - Apache Web 服务器
   - PHP 8.3
   - 前端资源（已构建）

2. **flowershop-db** (端口 3307)
   - MySQL 8.4 数据库
   - 数据库名：flowershop
   - 用户名：flowershop
   - 密码：flowershop

### 容器构建流程

1. **前端构建阶段**（Node.js 22）
   - 安装 npm 依赖
   - 编译前端资源（Vite）
   - 生成 `public/build` 目录

2. **后端构建阶段**（PHP 8.3 + Apache）
   - 安装 PHP 扩展（intl, mbstring, pdo_mysql, zip）
   - 安装 Composer 依赖
   - 复制前端构建结果
   - 配置 Apache
   - 设置文件权限

3. **启动阶段**（entrypoint.sh）
   - 生成 APP_KEY（如果不存在）
   - 运行数据库迁移
   - 创建存储链接
   - 缓存配置
   - 启动 Apache 服务器

## 🔧 环境配置

### docker-compose.yml 关键配置

```yaml
services:
  app:
    ports:
      - "8080:80"  # 外部访问端口:容器内部端口
    environment:
      DB_HOST: db
      DB_DATABASE: flowershop
      DB_USERNAME: flowershop
      DB_PASSWORD: flowershop
    volumes:
      - .:/var/www/html  # 代码实时同步

  db:
    ports:
      - "3307:3306"  # 避免与本地 MySQL 冲突
    volumes:
      - db-data:/var/lib/mysql  # 数据持久化
```

### .env 配置（Docker 环境）

Docker 会自动使用以下配置：
```env
APP_ENV=local
APP_DEBUG=true
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=flowershop
DB_USERNAME=flowershop
DB_PASSWORD=flowershop
```

## 📊 测试账号

### 管理员账号
- 邮箱：`admin@flowershop.local`
- 密码：`password123`

### 客户账号
- 邮箱：`customer1@example.com`
- 密码：`password123`

## 🐛 故障排查

### 问题 1：Docker 未安装

**错误提示：**
```
Docker 未安装！
```

**解决方案：**
1. 访问 https://www.docker.com/products/docker-desktop
2. 下载并安装 Docker Desktop
3. 重启计算机
4. 重新运行 `.\start-docker.ps1`

### 问题 2：Docker 未运行

**错误提示：**
```
Docker 未运行！
```

**解决方案：**
1. 从开始菜单启动 "Docker Desktop"
2. 等待托盘图标变绿
3. 重新运行脚本

### 问题 3：端口被占用

**错误提示：**
```
Error: port is already allocated
```

**解决方案：**
修改 `docker-compose.yml` 中的端口：
```yaml
ports:
  - "8081:80"  # 改为其他端口
```

### 问题 4：容器启动失败

**排查步骤：**
```powershell
# 查看详细日志
docker-compose logs app

# 查看数据库日志
docker-compose logs db

# 重新构建
docker-compose down
docker-compose up -d --build
```

### 问题 5：数据库连接失败

**解决方案：**
```powershell
# 检查数据库是否就绪
docker-compose logs db | Select-String "ready"

# 手动运行迁移
docker-compose exec app php artisan migrate
```

### 问题 6：权限错误

**解决方案：**
```powershell
# 进入容器修复权限
docker-compose exec app bash
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

## 📚 详细文档

- **完整 Docker 指南**: [DOCKER_SETUP.md](DOCKER_SETUP.md)
- **项目说明**: [README.md](README.md)
- **项目文档**: [docs/FLOWERSHOP.md](docs/FLOWERSHOP.md)

## ✅ 下一步操作

1. **安装 Docker Desktop**
   - 访问 https://www.docker.com/products/docker-desktop
   - 下载并安装
   - 重启计算机

2. **启动项目**
   ```powershell
   cd C:\Users\hungh\OneDrive\Documents\GitHub\FlowerShop
   .\start-docker.ps1
   ```

3. **访问网站**
   - http://localhost:8080

4. **登录管理后台**
   - http://localhost:8080/admin
   - 邮箱：admin@flowershop.local
   - 密码：password123

## 🎯 优势

使用 Docker 的好处：

1. ✅ **环境一致性** - 开发和生产环境完全一致
2. ✅ **快速部署** - 一条命令启动整个项目
3. ✅ **依赖隔离** - 不影响本地系统环境
4. ✅ **易于维护** - 统一的配置管理
5. ✅ **可移植性** - 可在任何支持 Docker 的系统运行
6. ✅ **数据持久化** - 数据库数据安全保存

## 📝 备注

- Docker 配置已完成，所有文件已就绪
- 启动脚本已添加详细的错误检查和提示
- 项目支持代码实时同步，修改代码后立即生效
- 数据库数据持久化保存，停止容器不会丢失数据
- 可以随时使用 `docker-compose down -v` 重置所有数据

---

**准备就绪！** 安装 Docker Desktop 后即可启动项目。
