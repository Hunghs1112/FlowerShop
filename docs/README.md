# 🌸 FlowerShop — E-commerce Platform for Fresh Flowers

Laravel-based e-commerce platform for selling fresh imported flowers with Zalo integration for order management.

## 🚀 Quick Start

```bash
# Start development server
php artisan serve

# Run migrations with seed data
php artisan migrate:fresh --seed

# Visit (default: Vietnamese)
http://localhost:8000/vi

# Visit (English)
http://localhost:8000/en
```

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
- **No Build Tools**: Manual CSS sync (no npm/Vite)
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
├── lang/
│   ├── vi/messages.php      # Vietnamese translations
│   └── en/messages.php      # English translations
├── database/migrations/      # 11 migrations (incl. translation cols)
├── resources/
│   ├── css/                 # 14 CSS files (edit here)
│   └── views/               # 29+ Blade templates (all i18n-ready)
└── routes/
    └── web.php              # 74 routes (locale-prefixed)
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

## 📝 Important Notes

1. **No User Registration** — Only admins can create user accounts
2. **No Payment Gateway** — Orders are inquiries sent to Zalo
3. **CSS Workflow** — Always edit in `resources/css/`, then sync
4. **Bilingual** — Customer pages support VI/EN, admin stays in Vietnamese
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

✅ **Bilingual System** — Song Ngữ VI + EN implemented

- URL prefix routing (/vi/ and /en/) ✅
- SetLocale middleware (auto-detect browser locale) ✅
- Language switcher in navbar ✅
- Session-based persistence ✅
- Translation files (lang/vi/ and lang/en/) ✅
- All views use translation keys ✅
- Database translation columns (migration created) ✅
- Product/Category display_name accessors ✅
- Admin panel (Vietnamese only) ✅
- README documentation ✅

## 📧 Support

For questions or issues, see documentation files:
- Technical details → `FLOWERSHOP.md`
- Commands → `COMMANDS.md`
- Files → `PROJECT_FILES.md`
- Checklist → `CHECKLIST.md`

---

**Built with Laravel 11** | **Bilingual VI + EN** | **Plain CSS** | **MySQL**
