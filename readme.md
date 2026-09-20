# Lâm Nhiên Thảo - 花店系统

一个基于 Laravel 11 的现代化花店电商系统。

## 项目概述

这是一个功能完整的花店在线商城，提供产品展示、购物车、订单管理、博客内容管理等功能。

## 核心功能

### 前台功能
- 🏠 **首页展示**：品牌展示、产品推荐、Instagram画廊
- 🌸 **产品系统**：产品分类、详情页、搜索、筛选
- 🛒 **购物车**：添加商品、数量管理、结账流程
- 💳 **订单管理**：订单创建、支付确认、邮件通知
- 📝 **博客系统**：文章列表、详情页、分类
- ❤️ **收藏功能**：收藏产品、管理收藏列表
- 👤 **用户中心**：个人信息、订单历史
- 💬 **在线咨询**：实时聊天（WebSocket）

### 后台管理
- 📊 **仪表盘**：销售统计、订单概览
- 🌺 **产品管理**：CRUD、多图上传、库存管理、**实时自动保存**
- 📁 **分类管理**：分类创建、编辑、删除
- 📰 **内容管理**：博客文章、页面管理
- 💬 **咨询管理**：查看和回复客户消息
- 👥 **用户管理**：用户列表、权限管理
- ⚙️ **系统设置**：站点配置、横幅管理、Zalo集成

#### 自动保存功能
- ⚡ **文本输入**：1.5秒防抖自动保存，按 Enter 键立即保存
- ⚡ **文本域**：1.5秒防抖自动保存，按 Ctrl+Enter 立即保存
- ⚡ **下拉框**：选择后立即保存
- ⚡ **复选框**：勾选后立即保存
- ⚡ **文件上传**：选择文件后自动上传

## 技术栈

- **框架**: Laravel 11.x
- **数据库**: MySQL
- **前端**: Blade模板 + 原生CSS
- **实时通信**: Swoole WebSocket
- **图片存储**: Laravel Storage (local disk)
- **邮件**: SMTP / Log驱动

## 🔧 安装与配置

### 1. 环境要求
- PHP >= 8.2
- MySQL >= 5.7
- Composer
- Node.js & npm (可选，用于前端资源编译)

### 2. 安装步骤

```bash
# 克隆项目
git clone <repository-url>
cd FlowerShop

# 安装依赖
composer install

# 配置环境
cp .env.example .env
php artisan key:generate

# 配置数据库
# 编辑 .env 文件，设置数据库连接信息

# 运行迁移和填充数据
php artisan migrate --seed

# 创建storage符号链接（重要！）
php artisan storage:link
```

### 3. Storage配置（图片上传必须）

**问题**：如果图片上传后无法显示，显示 403 Forbidden 错误

**原因**：`.htaccess` 文件中有规则阻止访问 `/storage/` 路径

**解决方案**：

1. 运行修复脚本：
```bash
php fix-storage-403.php
```

2. 或手动修复：
   - 确保 `public/storage` 是指向 `storage/app/public` 的符号链接
   - 在 `.htaccess` 中移除对 `/storage/` 的403重定向
   - 设置 `storage/app/public` 权限为 755

3. 验证配置：
   - 符号链接：`public/storage` → `../storage/app/public`
   - 上传的图片保存在：`storage/app/public/{categories|products|posts}/`
   - 访问URL：`http://yourdomain.com/storage/products/image.jpg`

### 4. 目录权限

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## 📁 项目结构

```
FlowerShop/
├── app/
│   ├── Http/Controllers/     # 控制器
│   │   ├── Admin/           # 后台控制器
│   │   └── Auth/            # 认证控制器
│   ├── Models/              # 数据模型
│   ├── Services/            # 业务逻辑服务
│   └── Mail/                # 邮件类
├── config/                  # 配置文件
├── database/
│   ├── migrations/          # 数据库迁移
│   └── seeders/             # 数据填充
├── public/                  # 公开访问目录
│   ├── css/                 # 样式文件
│   ├── js/                  # JavaScript文件
│   ├── images/              # 静态图片
│   └── storage/             # 符号链接 → storage/app/public
├── resources/
│   └── views/               # Blade模板
├── routes/
│   ├── web.php              # Web路由
│   ├── api.php              # API路由
│   └── channels.php         # 广播频道
└── storage/
    └── app/
        └── public/          # 上传文件存储（通过public/storage访问）
            ├── categories/  # 分类图片
            ├── products/    # 产品图片
            ├── posts/       # 文章图片
            └── settings/    # 系统设置图片
```

## 🎨 前端设计系统

### 颜色方案
- **主色调**：深蓝灰 (#0F172A, #1E293B)
- **文字颜色**：白色 (#F8FAFC)
- **强调色**：天蓝色 (#38BDF8) - 用于链接和按钮
- **操作色**：橙色 (#F97316) - 用于CTA按钮

### 字体
- 主字体：Josefin Sans - 应用于整个网站的所有文本
- 代码字体：'Courier New', monospace

### 组件样式
- 圆角：8-16px（卡片）、4px（表格和控件）
- 边框：1px slate色调
- 阴影：subtle, controlled shadows
- 动画：hover lift, 活动状态脉冲

## 🌐 API端点

### 公开API
- `GET /api/search` - 产品搜索
- `GET /api/products` - 产品列表（带分页）

### 需要认证的API
- `POST /api/cart` - 添加到购物车
- `GET /api/favorites` - 获取收藏列表
- `POST /api/favorites/{product}` - 添加收藏

## 💬 WebSocket聊天

系统使用 Swoole WebSocket 实现实时聊天功能。

### 启动WebSocket服务器

```bash
# 启动
php artisan swoole:start

# 停止
php artisan swoole:stop

# 重启
php artisan swoole:restart
```

### 配置
- 端口：9501（可在 `config/swoole.php` 修改）
- 连接URL：`ws://yourdomain.com:9501`

## 📧 邮件配置

系统支持SMTP邮件发送，用于：
- 订单确认邮件（发给客户）
- 新订单通知邮件（发给管理员）

### 配置步骤
1. 在 `.env` 中配置SMTP信息：
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your@email.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your@email.com
MAIL_FROM_NAME="Lâm Nhiên Thảo"
```

## 🔐 管理员账号

初始管理员账号（由 `UserSeeder` 创建）：
- **邮箱**: admin@flowershop.com
- **密码**: password
- **角色**: admin

⚠️ **生产环境请立即修改密码！**

## 🚀 部署到cPanel

### 1. 准备工作
- 确保主机支持 PHP 8.2+
- 确保主机支持 `symlink()` 函数

### 2. 上传文件
- 将项目根目录所有文件上传到 `public_html/`
- 或将Laravel文件上传到子目录

### 3. 配置
```bash
# SSH连接后执行
cd public_html
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
php fix-storage-403.php
```

### 4. 环境变量
编辑 `.env`：
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

### 5. 常见问题

**问题1：500错误**
- 检查 `storage/` 和 `bootstrap/cache/` 权限
- 清除缓存：`php artisan cache:clear`

**问题2：图片403错误**
- 运行 `php fix-storage-403.php`
- 检查 `.htaccess` 是否阻止 `/storage/` 访问

**问题3：符号链接创建失败**
- 联系主机商启用 `symlink()` 函数
- 或手动复制文件到 `public/storage/`

## 🛠️ 开发指南

### 添加新功能
1. 创建迁移：`php artisan make:migration create_xxx_table`
2. 创建模型：`php artisan make:model ModelName`
3. 创建控制器：`php artisan make:controller ControllerName`
4. 定义路由：在 `routes/web.php` 中添加
5. 创建视图：在 `resources/views/` 中添加Blade文件

### 代码规范
- 遵循 PSR-12 编码标准
- 使用类型提示
- 编写清晰的注释
- 使用依赖注入
- 遵循 SOLID 原则

### 测试
```bash
# 运行所有测试
php artisan test

# 运行特定测试
php artisan test --filter TestName
```

## 📝 数据库设计

### 主要表结构

- `users` - 用户表
- `categories` - 产品分类
- `products` - 产品信息
- `product_images` - 产品图片（多图支持）
- `cart_items` - 购物车
- `orders` - 订单
- `order_items` - 订单明细
- `posts` - 博客文章
- `pages` - 静态页面
- `inquiries` - 客户咨询
- `chat_messages` - 聊天消息
- `favorites` - 收藏
- `settings` - 系统设置

## 🔄 最近更新

### 2026-09-17
- ✅ 修复 Storage 403 Forbidden 错误
- ✅ 更新 .htaccess 配置，允许访问 /storage/ 路径
- ✅ 创建 fix-storage-403.php 自动修复脚本
- ✅ 创建项目 README.md 文档
- ✅ 更新网站字体为 Josefin Sans（应用于整个客户端网站）
- ✅ 修复产品编辑页面自动保存路由错误（admin/products/{id}/auto-save → admin/products/{id}/update-field）

### 功能改进建议
1. 添加产品库存预警功能
2. 实现优惠券/折扣码系统
3. 添加订单状态追踪
4. 集成更多支付网关
5. 添加产品评论和评分
6. 实现多语言支持（i18n）
7. 添加SEO优化功能

## 📞 技术支持

如遇到问题，请检查：
1. Laravel日志：`storage/logs/laravel.log`
2. Swoole日志：`storage/logs/swoole.log`
3. Web服务器错误日志

## 📄 许可证

本项目为私有项目，未经授权不得使用。

---

**最后更新**: 2026年9月17日
**Laravel版本**: 11.x
**PHP版本要求**: >= 8.2
