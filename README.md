# 🌸 FlowerShop — E-commerce Platform for Fresh Flowers

Laravel-based e-commerce platform for selling fresh imported flowers with Zalo integration for order management.

## 🚀 Quick Start

### 方式一：使用 Docker（推荐）

**首次安装 Docker：**
1. 访问 https://www.docker.com/products/docker-desktop
2. 下载并安装 Docker Desktop for Windows
3. 重启计算机
4. 启动 Docker Desktop

**启动项目：**
```powershell
# 首次启动（自动检查环境）
.\start-docker.ps1

# 后续快速启动
.\start.ps1

# 停止服务
.\stop.ps1

# 查看日志
.\logs.ps1
```

**访问地址：**
- 网站: http://localhost:8080
- 数据库: localhost:3307

**详细说明：** 查看 [DOCKER_SETUP.md](DOCKER_SETUP.md)

### 方式二：传统方式

```bash
# 安装依赖
composer install

# 配置环境
cp .env.example .env
php artisan key:generate

# 数据库迁移
php artisan migrate:fresh --seed

# 启动服务器
php artisan serve

# 访问地址
http://localhost:8000/vi
```

## 🐳 Docker 命令

```powershell
# 启动所有容器
docker-compose up -d

# 停止所有容器
docker-compose stop

# 查看容器状态
docker-compose ps

# 查看日志
docker-compose logs -f app

# 进入应用容器
docker-compose exec app bash

# 运行 Laravel 命令
docker-compose exec app php artisan migrate

# 重新构建
docker-compose up -d --build

# 停止并删除所有容器
docker-compose down
```

## 📦 Cấu Trúc Dữ Liệu

### Phân Cấp Danh Mục 3 Cấp

Hệ thống sử dụng cấu trúc danh mục 3 cấp:

```
Category (Danh mục chính)
├── Subcategory (Danh mục phụ)
│   ├── Product 1
│   ├── Product 2
│   └── Product 3
└── Subcategory 2
    └── Product 4
```

**Models:**
- `Category` - Danh mục cấp 1 (không có parent)
- `Subcategory` - Danh mục cấp 2 (có `category_id`)
- `Product` - Sản phẩm (có `category_id` và `subcategory_id`)

**Relationships:**
- Category → hasMany Subcategories
- Category → hasMany Products (thông qua subcategories)
- Subcategory → belongsTo Category
- Subcategory → hasMany Products
- Product → belongsTo Category
- Product → belongsTo Subcategory

**Quản lý:**
- Admin → Danh Mục: Quản lý danh mục cấp 1 (không có chọn parent)
- Admin → Danh Mục Phụ: Quản lý danh mục cấp 2 (có chọn danh mục cha)
- Admin → Sản Phẩm: Có chọn cả Category và Subcategory

## 🌍 Bilingual System (Song Ngữ)

The website supports **Vietnamese (VI)** and **English (EN)** with automatic language detection.

### How it works

- **Default**: `/vi/` prefix (Vietnamese) — auto-detected from browser language
- **URLs**: All customer pages have locale prefix — `/vi/san-pham`, `/en/products`
- **Switch**: Click the **EN/VI** button in the top-right navbar to toggle language
- **Persistence**: Language preference is stored in session
- **Admin**: Admin panel remains in Vietnamese only

### Language Files

- `lang/vi/messages.php` — Vietnamese (default)
- `lang/en/messages.php` — English

### Adding Translations

```php
// In lang/vi/messages.php
'my_section' => [
    'greeting' => 'Xin chào!',
    'welcome' => 'Chào mừng bạn',
],

// In lang/en/messages.php
'my_section' => [
    'greeting' => 'Hello!',
    'welcome' => 'Welcome',
],
```

Then in Blade templates:
```blade
{{ __('messages.my_section.greeting') }}
```

### Database Translations

Products, categories, and pages support English translations via `_en` columns:
- `name_en`, `slug_en`, `short_description_en` (products)
- `name_en`, `slug_en`, `description_en` (categories)
- `title_en`, `content_en` (pages)

To enable, run the migration after adding English data:
```bash
php artisan migrate
```

### Key Files

| File | Purpose |
|------|---------|
| `app/Http/Middleware/SetLocale.php` | Locale detection middleware |
| `app/Providers/AppServiceProvider.php` | Helper `localized_url()` |
| `resources/views/components/language-switcher.blade.php` | Navbar switcher button |
| `routes/web.php` | All routes under `{locale}` prefix |

## 📧 Email & Zalo Notifications

The system sends email and Zalo notifications when orders are placed.

### Configuration

Edit `.env` file:

```env
# Gmail SMTP Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=xxxx xxxx xxxx xxxx (16-char app password)
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Lâm Nhiên Thảo"

# Admin email for order notifications
MAIL_ADMIN_EMAIL=admin@example.com
MAIL_NOTIFICATIONS_ENABLED=true

# Zalo OA Configuration
ZALO_OA_ID=your-zalo-oa-id
ZALO_ACCESS_TOKEN=your-zalo-access-token
ZALO_ADMIN_PHONE=0912345678
```

### Gmail Setup

1. Enable 2-Factor Authentication on your Google account
2. Go to https://myaccount.google.com/apppasswords
3. Generate an App Password for "Mail"
4. Use the 16-character App Password (no spaces) in `MAIL_PASSWORD`

**Note:** Gmail has a limit of 500 emails per day.

### Zalo OA Setup

1. Create Official Account at https://oa.zalo.me
2. Go to Zalo Developer Portal: https://developers.zalo.me
3. Create an app and get your OA ID
4. Get access token with 'send message' permission
5. Set admin phone to receive order notifications

### Features

- ✅ Customer confirmation email (if email provided)
- ✅ Admin notification email
- ✅ Zalo notification to admin
- ✅ Graceful degradation (order still saves if notifications fail)
- ✅ HTML injection prevention
- ✅ Input sanitization

### Test Cases Covered

- Happy path: email/Zalo sent successfully
- Invalid SMTP credentials: error logged, order still saves
- Gmail rate limit: handled gracefully
- Invalid email: validation prevents submission
- HTML injection: sanitized via `e()` helper
- Double-click: idempotency via unique order ID

## 🔐 Test Accounts

**Admin**
- Email: `admin@flowershop.local`
- Password: `password123`

**Customer**
- Email: `customer1@example.com`
- Password: `password123`

## ⚙️ CSS Workflow

After editing CSS files in `resources/css/`:
```bash
# Linux/Mac
bash sync-css.sh

# Windows
.\sync-css.ps1
```

## 📚 Documentation

- **[DOCKER_SETUP.md](DOCKER_SETUP.md)** — Docker 安装和使用指南
- **[BILINGUAL_OPTIMIZATION.md](docs/BILINGUAL_OPTIMIZATION.md)** — 双语功能优化文档 ⭐ NEW
- **[FLOWERSHOP.md](FLOWERSHOP.md)** — Complete project documentation
- **[SETUP_COMPLETE.md](docs/SETUP_COMPLETE.md)** — Setup completion summary
- **[COMMANDS.md](docs/COMMANDS.md)** — Quick command reference
- **[PROJECT_FILES.md](docs/PROJECT_FILES.md)** — File structure reference
- **[CHECKLIST.md](docs/CHECKLIST.md)** — Implementation checklist

## 🎯 Key Features

### Public Features
- **Bilingual** — Vietnamese + English with URL-based switching
- Product catalog with filtering
- Shopping cart (guest + authenticated)
- Checkout without payment gateway
- Quick order for single products
- User favorites
- Blog section
- Contact via Zalo

### Admin Features
- Product management (CRUD with images)
- Category management (hierarchical)
- User management (admin creates accounts)
- Inquiry management (order requests)
- Blog post management
- Site settings management
- English translation fields for products/categories/pages

## 🛠️ Tech Stack

- **Backend**: Laravel 11 (PHP 8.2+)
- **Database**: MySQL/MariaDB
- **Frontend**: Blade templates + Plain CSS
- **Deployment**: Docker + Docker Compose
- **Localization**: Laravel built-in (session + URL prefix)
- **Locales**: Vietnamese (`vi`) + English (`en`)
- **Timezone**: `Asia/Ho_Chi_Minh`

## 📊 Project Structure

```
FlowerShop/
├── app/
│   ├── Http/Controllers/      # 21 controllers
│   ├── Http/Middleware/      # SetLocale.php (i18n)
│   ├── Models/               # 10 models (+ display accessors)
│   └── Services/            # 4 service classes
├── docker/
│   ├── apache-vhost.conf     # Apache configuration
│   └── entrypoint.sh         # Container startup script
├── lang/
│   ├── vi/messages.php      # Vietnamese translations
│   └── en/messages.php      # English translations
├── database/migrations/      # 11 migrations (incl. translation cols)
├── resources/
│   ├── css/                 # 14 CSS files (edit here)
│   └── views/               # 29+ Blade templates (all i18n-ready)
├── routes/
│   └── web.php              # 74 routes (locale-prefixed)
├── Dockerfile               # Application container definition
├── docker-compose.yml       # Multi-container orchestration
├── start-docker.ps1         # Full Docker startup script
├── start.ps1                # Quick start script
├── stop.ps1                 # Stop containers script
└── logs.ps1                 # View logs script
```

## 🗄️ Database

**Tables**: 10 (users, categories, products, product_images, cart_items, inquiries, posts, favorites, pages, settings)

**Translation Columns** (added by `add_translation_columns` migration):
- `products.name_en`, `products.slug_en`, `products.short_description_en`
- `categories.name_en`, `categories.slug_en`, `categories.description_en`
- `pages.title_en`, `pages.content_en`

## 🔧 Common Commands

```bash
# Database
php artisan migrate:fresh --seed  # Reset database
php artisan migrate               # Run new migrations
php artisan db:seed              # Run seeders only

# Cache
php artisan optimize:clear        # Clear all caches
php artisan config:cache         # Cache config

# Routes
php artisan route:list           # Show all routes

# Storage
php artisan storage:link         # Create storage symlink
```

## 🎯 Giao Diện Catalog Thống Nhất (Mới!)

### Tính Năng
Gộp 3 phần quản lý (Danh mục, Danh mục phụ, Sản phẩm) vào **1 giao diện duy nhất** với tab navigation.

### Truy Cập
- **URL Admin:** `/admin/catalog`
- **Menu:** Sidebar > Quản Lý > "Quản Lý Catalog"

### Ưu Điểm
- ✅ Tổ chức khoa học hơn - nhóm 3 phần liên quan
- ✅ Giảm số menu items trong sidebar
- ✅ Tab navigation với badge số lượng
- ✅ Bộ lọc thông minh theo từng tab
- ✅ Chuyển tab mượt mà, giữ nguyên filters
- ✅ Responsive hoàn toàn

### Chi Tiết Kỹ Thuật
Xem file: [CATALOG_UNIFIED_IMPLEMENTATION.md](CATALOG_UNIFIED_IMPLEMENTATION.md)

## 📝 Important Notes

1. **No User Registration** — Only admins can create user accounts
2. **No Payment Gateway** — Orders are inquiries sent to Zalo
3. **CSS Workflow** — Always edit in `resources/css/`, then sync
4. **Bilingual** — Customer pages support VI/EN, admin stays in Vietnamese
5. **Admin Only** — User creation restricted to admin role
6. **Docker** — Recommended for consistent development environment

## 🎨 Design System

- **Colors**: CSS Custom Properties in `theme.css`
- **Fonts**: Inter (UI) + IBM Plex Mono (code)
- **Spacing**: 4px base unit (var(--space-*))
- **Responsive**: Desktop-first with media queries
- **Components**: Reusable partials in `resources/views/partials/`

## 🌐 Routes Overview

| Route Group | Count | Examples |
|-------------|-------|----------|
| Public (VI) | 15 | `/vi/`, `/vi/san-pham`, `/vi/gio-hang` |
| Public (EN) | 15 | `/en/`, `/en/products`, `/en/cart` |
| Admin | 45 | `/admin`, `/admin/products`, `/admin/settings` |

## 🔒 Security

- Role-based access control (admin/customer)
- AdminMiddleware protects admin routes
- CSRF protection on all forms
- Password hashing (bcrypt)
- Session-based authentication

## 📦 Installation

### Using Docker (Recommended)

```powershell
# 1. Install Docker Desktop (if not installed)
# Visit: https://www.docker.com/products/docker-desktop

# 2. Start the project
.\start-docker.ps1

# 3. Open browser
# http://localhost:8080
```

### Traditional Installation

```bash
# 1. Install dependencies
composer install

# 2. Copy environment
cp .env.example .env

# 3. Generate key
php artisan key:generate

# 4. Configure database in .env
DB_DATABASE=flowershop
DB_USERNAME=root
DB_PASSWORD=root

# 5. Run migrations
php artisan migrate:fresh --seed

# 6. Create storage symlink
php artisan storage:link

# 7. Sync CSS
bash sync-css.sh

# 8. Start server
php artisan serve
```

## 🚦 Status

✅ **Docker Support** — Complete containerization setup
✅ **Bilingual System** — Song Ngữ VI + EN implemented

- Docker + Docker Compose configuration ✅
- Automated startup scripts ✅
- MySQL database container ✅
- Apache web server ✅
- URL prefix routing (/vi/ and /en/) ✅
- SetLocale middleware (auto-detect browser locale) ✅
- Language switcher in navbar ✅
- Session-based persistence ✅
- Translation files (lang/vi/ and lang/en/) ✅
- All views use translation keys ✅
- Database translation columns (migration created) ✅
- Product/Category display_name accessors ✅
- Admin panel (Vietnamese only) ✅
- Complete documentation ✅

## 📧 Support

For questions or issues, see documentation files:
- Docker setup → `DOCKER_SETUP.md`
- Technical details → `FLOWERSHOP.md`
- Commands → `COMMANDS.md`
- Files → `PROJECT_FILES.md`
- Checklist → `CHECKLIST.md`

---

**Built with Laravel 11** | **Docker Ready** | **Bilingual VI + EN** | **Plain CSS** | **MySQL**
