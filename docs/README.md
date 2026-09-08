# 🌸 FlowerShop — E-commerce Platform for Fresh Flowers

Laravel-based e-commerce platform for selling fresh imported flowers with Zalo integration for order management.

## 🚀 Quick Start

```bash
# Start development server
php artisan serve

# Visit
http://localhost:8000

# Admin panel
http://localhost:8000/admin
```

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

- **[FLOWERSHOP.md](FLOWERSHOP.md)** — Complete project documentation
- **[SETUP_COMPLETE.md](SETUP_COMPLETE.md)** — Setup completion summary
- **[COMMANDS.md](COMMANDS.md)** — Quick command reference
- **[PROJECT_FILES.md](PROJECT_FILES.md)** — File structure reference
- **[CHECKLIST.md](CHECKLIST.md)** — Implementation checklist

## 🎯 Key Features

### Public Features
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

## 🛠️ Tech Stack

- **Backend**: Laravel 11 (PHP 8.2+)
- **Database**: MySQL/MariaDB
- **Frontend**: Blade templates + Plain CSS
- **No Build Tools**: Manual CSS sync (no npm/Vite)
- **Locale**: Vietnamese (`vi`)
- **Timezone**: `Asia/Ho_Chi_Minh`

## 📊 Project Structure

```
FlowerShop/
├── app/
│   ├── Http/Controllers/      # 21 controllers
│   ├── Models/                # 10 models
│   └── Services/              # 4 service classes
├── database/
│   ├── migrations/            # 10 migrations
│   └── seeders/               # 6 seeders
├── resources/
│   ├── css/                   # 14 CSS files (edit here)
│   └── views/                 # 29+ Blade templates
├── public/
│   └── css/                   # Synced CSS (don't edit)
└── routes/
    └── web.php                # 74 routes
```

## 🗄️ Database

**Tables**: 10 (users, categories, products, product_images, cart_items, inquiries, posts, favorites, pages, settings)

**Sample Data**:
- 1 admin + 2 customers
- 8 categories
- 12 products
- 5 blog posts
- 3 static pages
- 9 site settings

## 🔧 Common Commands

```bash
# Database
php artisan migrate:fresh --seed  # Reset database
php artisan db:seed               # Run seeders only

# Cache
php artisan optimize:clear        # Clear all caches
php artisan config:cache          # Cache config

# Routes
php artisan route:list            # Show all routes

# Storage
php artisan storage:link          # Create storage symlink
```

## 📝 Important Notes

1. **No User Registration** — Only admins can create user accounts
2. **No Payment Gateway** — Orders are inquiries sent to Zalo
3. **CSS Workflow** — Always edit in `resources/css/`, then sync
4. **Vietnamese** — Default locale, all content in Vietnamese
5. **Admin Only** — User creation restricted to admin role

## 🎨 Design System

- **Colors**: CSS Custom Properties in `theme.css`
- **Fonts**: Inter (UI) + IBM Plex Mono (code)
- **Spacing**: 4px base unit (var(--space-*))
- **Responsive**: Desktop-first with media queries
- **Components**: Reusable partials in `resources/views/partials/`

## 🌐 Routes Overview

| Route Group | Count | Examples |
|-------------|-------|----------|
| Public | 15 | `/`, `/san-pham`, `/tin-tuc` |
| Auth | 6 | `/dang-nhap`, `/quen-mat-khau` |
| User | 8 | `/gio-hang`, `/thanh-toan`, `/tai-khoan` |
| Admin | 45 | `/admin`, `/admin/products`, `/admin/settings` |

## 🔒 Security

- Role-based access control (admin/customer)
- AdminMiddleware protects admin routes
- CSRF protection on all forms
- Password hashing (bcrypt)
- Session-based authentication

## 📦 Installation

Already installed! Project is ready to use.

If starting fresh on another machine:

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

✅ **Phase 1 Complete** — Skeleton Setup

- Database structure ✅
- Business logic ✅
- All controllers ✅
- All views (HTML structure) ✅
- CSS architecture ✅
- Sample data ✅
- Documentation ✅

**Next**: Design implementation phase

## 📧 Support

For questions or issues, see documentation files:
- Technical details → `FLOWERSHOP.md`
- Commands → `COMMANDS.md`
- Files → `PROJECT_FILES.md`
- Checklist → `CHECKLIST.md`

---

**Built with Laravel 11** | **Vietnamese Locale** | **Plain CSS** | **MySQL**
