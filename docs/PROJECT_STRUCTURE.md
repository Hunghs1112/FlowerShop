# FlowerShop — Project Structure

```
FlowerShop/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── CategoryController.php
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── InquiryController.php
│   │   │   │   ├── PageController.php
│   │   │   │   ├── PostController.php
│   │   │   │   ├── ProductController.php
│   │   │   │   ├── SettingController.php
│   │   │   │   └── UserController.php
│   │   │   ├── Auth/
│   │   │   │   ├── ForgotPasswordController.php
│   │   │   │   ├── LoginController.php
│   │   │   │   └── ResetPasswordController.php
│   │   │   ├── CartController.php
│   │   │   ├── CategoryController.php
│   │   │   ├── CheckoutController.php
│   │   │   ├── Controller.php
│   │   │   ├── FavoriteController.php
│   │   │   ├── HomeController.php
│   │   │   ├── PageController.php
│   │   │   ├── PostController.php
│   │   │   ├── ProductController.php
│   │   │   ├── ProfileController.php
│   │   │   └── QuickOrderController.php
│   │   └── Middleware/
│   │       └── AdminMiddleware.php
│   ├── Models/
│   │   ├── CartItem.php
│   │   ├── Category.php
│   │   ├── Favorite.php
│   │   ├── Inquiry.php
│   │   ├── Page.php
│   │   ├── Post.php
│   │   ├── Product.php
│   │   ├── ProductImage.php
│   │   ├── Setting.php
│   │   └── User.php
│   └── Services/
│       ├── CartService.php
│       ├── CategoryService.php
│       ├── ProductService.php
│       └── SettingService.php
├── bootstrap/
│   └── app.php
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── cache.php
│   ├── database.php
│   ├── filesystems.php
│   ├── logging.php
│   ├── mail.php
│   ├── queue.php
│   ├── services.php
│   └── session.php
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2026_09_07_215220_create_categories_table.php
│   │   ├── 2026_09_07_215231_create_products_table.php
│   │   ├── 2026_09_07_215232_create_product_images_table.php
│   │   ├── 2026_09_07_215233_create_cart_items_table.php
│   │   ├── 2026_09_07_215234_create_inquiries_table.php
│   │   ├── 2026_09_07_215235_create_posts_table.php
│   │   ├── 2026_09_07_215236_create_favorites_table.php
│   │   ├── 2026_09_07_215237_create_pages_table.php
│   │   └── 2026_09_07_215238_create_settings_table.php
│   └── seeders/
│       ├── CategorySeeder.php
│       ├── DatabaseSeeder.php
│       ├── PageSeeder.php
│       ├── PostSeeder.php
│       ├── ProductSeeder.php
│       ├── SettingSeeder.php
│       └── UserSeeder.php
├── public/
│   ├── css/
│   │   ├── account.css
│   │   ├── admin.css
│   │   ├── app.css
│   │   ├── auth.css
│   │   ├── blog.css
│   │   ├── checkout.css
│   │   ├── fonts.css
│   │   ├── footer.css
│   │   ├── hero.css
│   │   ├── home.css
│   │   ├── navbar.css
│   │   ├── pages.css
│   │   ├── products.css
│   │   └── theme.css
│   ├── storage/           → symlink to storage/app/public
│   └── index.php
├── resources/
│   ├── css/
│   │   ├── account.css
│   │   ├── admin.css
│   │   ├── app.css
│   │   ├── auth.css
│   │   ├── blog.css
│   │   ├── checkout.css
│   │   ├── fonts.css
│   │   ├── footer.css
│   │   ├── hero.css
│   │   ├── home.css
│   │   ├── navbar.css
│   │   ├── pages.css
│   │   ├── products.css
│   │   └── theme.css
│   └── views/
│       ├── admin/
│       │   ├── categories/
│       │   │   ├── create.blade.php
│       │   │   ├── edit.blade.php
│       │   │   └── index.blade.php
│       │   ├── inquiries/
│       │   │   ├── index.blade.php
│       │   │   └── show.blade.php
│       │   ├── pages/
│       │   │   ├── create.blade.php
│       │   │   ├── edit.blade.php
│       │   │   └── index.blade.php
│       │   ├── partials/
│       │   │   ├── sidebar.blade.php
│       │   │   └── topbar.blade.php
│       │   ├── posts/
│       │   │   ├── create.blade.php
│       │   │   ├── edit.blade.php
│       │   │   └── index.blade.php
│       │   ├── products/
│       │   │   ├── create.blade.php
│       │   │   ├── edit.blade.php
│       │   │   ├── form.blade.php
│       │   │   └── index.blade.php
│       │   ├── settings/
│       │   │   └── index.blade.php
│       │   ├── users/
│       │   │   ├── create.blade.php
│       │   │   ├── edit.blade.php
│       │   │   └── index.blade.php
│       │   └── dashboard.blade.php
│       ├── auth/
│       │   ├── passwords/
│       │   │   ├── email.blade.php
│       │   │   └── reset.blade.php
│       │   └── login.blade.php
│       ├── blog/
│       │   ├── index.blade.php
│       │   └── show.blade.php
│       ├── cart/
│       │   └── index.blade.php
│       ├── categories/
│       │   └── show.blade.php
│       ├── checkout/
│       │   ├── index.blade.php
│       │   └── success.blade.php
│       ├── favorites/
│       │   └── index.blade.php
│       ├── layouts/
│       │   ├── admin.blade.php
│       │   └── app.blade.php
│       ├── pages/
│       │   ├── about.blade.php
│       │   ├── contact.blade.php
│       │   └── policy.blade.php
│       ├── partials/
│       │   ├── footer.blade.php
│       │   ├── navbar.blade.php
│       │   └── product-card.blade.php
│       ├── products/
│       │   ├── index.blade.php
│       │   └── show.blade.php
│       ├── profile/
│       │   └── show.blade.php
│       └── home.blade.php
├── routes/
│   ├── console.php
│   └── web.php
├── storage/
│   ├── app/
│   │   └── public/
│   │       ├── categories/
│   │       ├── posts/
│   │       ├── products/
│   │       └── settings/
│   ├── framework/
│   └── logs/
├── tests/
│   ├── Feature/
│   └── Unit/
├── .env
├── .env.example
├── .gitignore
├── artisan
├── composer.json
├── composer.lock
├── phpunit.xml
├── sync-css.ps1
├── sync-css.sh
├── CHECKLIST.md
├── COMMANDS.md
├── FLOWERSHOP.md
├── PROJECT_FILES.md
├── PROJECT_STRUCTURE.md
├── README.md
└── SETUP_COMPLETE.md
```

## Summary

| Type | Count | Location |
|------|-------|----------|
| Controllers | 21 | app/Http/Controllers/ |
| Models | 10 | app/Models/ |
| Services | 4 | app/Services/ |
| Middleware | 1 | app/Http/Middleware/ |
| Migrations | 13 | database/migrations/ |
| Seeders | 7 | database/seeders/ |
| Blade Views | 40+ | resources/views/ |
| CSS Files | 14 | resources/css/ (synced to public/css/) |
| Routes | 74 | routes/web.php |
| Documentation | 6 | root directory |

## Key Directories

### Application Logic
- `app/Http/Controllers/` — All controllers (Admin, Auth, Public)
- `app/Models/` — Eloquent models with relationships
- `app/Services/` — Business logic layer

### Database
- `database/migrations/` — Database schema
- `database/seeders/` — Sample data

### Views & Assets
- `resources/views/` — Blade templates
- `resources/css/` — Editable CSS files
- `public/css/` — Synced CSS (auto-generated)
- `public/storage/` — Symlink to uploaded files

### Configuration
- `config/` — Laravel configuration files
- `.env` — Environment variables
- `routes/web.php` — Route definitions

### Documentation
- `README.md` — Quick start guide
- `FLOWERSHOP.md` — Complete documentation
- `COMMANDS.md` — Command reference
- `PROJECT_FILES.md` — File reference
- `CHECKLIST.md` — Implementation checklist
- `SETUP_COMPLETE.md` — Setup summary

## Notes

- **Vendor**: Not shown (composer dependencies)
- **Node Modules**: Not used (no npm)
- **Storage**: Contains logs, cache, uploaded files
- **Bootstrap Cache**: Contains compiled files
