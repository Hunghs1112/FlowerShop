# FlowerShop — Important Files Reference

## 📚 Documentation Files

- **FLOWERSHOP.md** — Complete project documentation
- **SETUP_COMPLETE.md** — Setup completion summary
- **COMMANDS.md** — Quick command reference
- **PROJECT_FILES.md** — This file (file structure reference)
- **README.md** — Laravel default readme

## ⚙️ Configuration Files

- **.env** — Environment configuration (database, app settings)
- **config/app.php** — Application configuration (timezone: Asia/Ho_Chi_Minh)
- **config/database.php** — Database configuration
- **bootstrap/app.php** — Bootstrap application (AdminMiddleware registered)

## 🗄️ Database Files

### Migrations (database/migrations/)
1. `0001_01_01_000000_create_users_table.php` — Users table (modified with role, phone, address)
2. `2026_09_07_215220_create_categories_table.php` — Categories (hierarchical)
3. `2026_09_07_215231_create_products_table.php` — Products
4. `2026_09_07_215232_create_product_images_table.php` — Product images
5. `2026_09_07_215233_create_cart_items_table.php` — Shopping cart
6. `2026_09_07_215234_create_inquiries_table.php` — Order inquiries
7. `2026_09_07_215235_create_posts_table.php` — Blog posts
8. `2026_09_07_215236_create_favorites_table.php` — User favorites
9. `2026_09_07_215237_create_pages_table.php` — Static pages
10. `2026_09_07_215238_create_settings_table.php` — Site settings

### Seeders (database/seeders/)
1. `DatabaseSeeder.php` — Main seeder (calls all others)
2. `UserSeeder.php` — Seeds admin + 2 customers
3. `CategorySeeder.php` — Seeds 8 categories (occasions)
4. `ProductSeeder.php` — Seeds 12 products with images
5. `PostSeeder.php` — Seeds 5 blog posts
6. `PageSeeder.php` — Seeds 3 static pages
7. `SettingSeeder.php` — Seeds 9 site settings

## 🎯 Models (app/Models/)

1. **User.php** — User model with roles, favorites, cart, inquiries
2. **Category.php** — Hierarchical categories with products
3. **Product.php** — Products with images, favorites, cart
4. **ProductImage.php** — Product image gallery
5. **CartItem.php** — Shopping cart items (session + user)
6. **Inquiry.php** — Order inquiries (replaces orders)
7. **Post.php** — Blog posts
8. **Favorite.php** — User product favorites
9. **Page.php** — Static content pages
10. **Setting.php** — Site settings with caching

## 🔧 Services (app/Services/)

1. **CategoryService.php** — Category logic (tree, breadcrumb, descendants)
2. **ProductService.php** — Product logic (filter, search, featured, related)
3. **CartService.php** — Cart logic (add, update, remove, merge, total)
4. **SettingService.php** — Settings logic with caching

## 🎮 Controllers

### Public Controllers (app/Http/Controllers/)
1. **HomeController.php** — Homepage with featured products
2. **ProductController.php** — Product listing, detail, search
3. **CategoryController.php** — Category pages with products
4. **CartController.php** — Cart management
5. **CheckoutController.php** — Checkout and success pages
6. **QuickOrderController.php** — Quick order for single products
7. **FavoriteController.php** — User favorites management
8. **ProfileController.php** — User profile and inquiry history
9. **PostController.php** — Blog listing and detail
10. **PageController.php** — About, contact, policy pages

### Auth Controllers (app/Http/Controllers/Auth/)
1. **LoginController.php** — Login/logout
2. **ForgotPasswordController.php** — Password reset request
3. **ResetPasswordController.php** — Password reset form

### Admin Controllers (app/Http/Controllers/Admin/)
1. **DashboardController.php** — Admin dashboard with stats
2. **CategoryController.php** — Category CRUD
3. **ProductController.php** — Product CRUD with images
4. **InquiryController.php** — View inquiries and update status
5. **PostController.php** — Blog post CRUD
6. **UserController.php** — User CRUD (admin creates customers)
7. **PageController.php** — Static page CRUD
8. **SettingController.php** — Site settings management

## 🛡️ Middleware

- **app/Http/Middleware/AdminMiddleware.php** — Protects admin routes

## 🛣️ Routes

- **routes/web.php** — All 74 routes (public, auth, admin)

## 🎨 CSS Files (resources/css/ → synced to public/css/)

1. **theme.css** — CSS variables, base styles, utilities
2. **fonts.css** — Font imports (Inter, IBM Plex Mono)
3. **navbar.css** — Navigation bar styles
4. **footer.css** — Footer styles
5. **home.css** — Homepage sections
6. **hero.css** — Hero banner
7. **products.css** — Product pages (listing, detail)
8. **blog.css** — Blog pages
9. **auth.css** — Login and auth pages
10. **account.css** — User account pages
11. **pages.css** — Static content pages
12. **checkout.css** — Cart and checkout pages
13. **admin.css** — Admin panel styles
14. **app.css** — Additional app-wide styles

## 🎭 Blade Templates

### Layouts (resources/views/layouts/)
- **app.blade.php** — Main public layout
- **admin.blade.php** — Admin panel layout

### Partials (resources/views/partials/)
- **navbar.blade.php** — Main navigation
- **footer.blade.php** — Site footer
- **product-card.blade.php** — Reusable product card

### Admin Partials (resources/views/admin/partials/)
- **sidebar.blade.php** — Admin sidebar navigation
- **topbar.blade.php** — Admin top bar

### Public Views (resources/views/)
- **home.blade.php** — Homepage
- **products/index.blade.php** — Product listing
- **products/show.blade.php** — Product detail
- **categories/show.blade.php** — Category page
- **cart/index.blade.php** — Shopping cart
- **checkout/index.blade.php** — Checkout form
- **checkout/success.blade.php** — Order success
- **blog/index.blade.php** — Blog listing
- **blog/show.blade.php** — Blog post
- **pages/about.blade.php** — About page
- **pages/contact.blade.php** — Contact page
- **pages/policy.blade.php** — Dynamic policy pages

### Account Views (resources/views/account/)
- **profile.blade.php** — User profile
- **inquiries.blade.php** — Order history
- **favorites.blade.php** — Favorite products

### Auth Views (resources/views/auth/)
- **login.blade.php** — Login form
- **passwords/email.blade.php** — Password reset request
- **passwords/reset.blade.php** — Password reset form

### Admin Views (resources/views/admin/)
- **dashboard.blade.php** — Admin dashboard
- **products/index.blade.php** — Product list
- **products/create.blade.php** — Create product
- **products/edit.blade.php** — Edit product
- **inquiries/index.blade.php** — Inquiry list
- **inquiries/show.blade.php** — Inquiry detail
- **categories/index.blade.php** — Category list
- **categories/create.blade.php** — Create category
- **categories/edit.blade.php** — Edit category
- **users/index.blade.php** — User list
- **users/create.blade.php** — Create user
- **users/edit.blade.php** — Edit user
- **posts/index.blade.php** — Post list
- **posts/create.blade.php** — Create post
- **posts/edit.blade.php** — Edit post
- **pages/index.blade.php** — Page list
- **pages/create.blade.php** — Create page
- **pages/edit.blade.php** — Edit page
- **settings/index.blade.php** — Site settings

## 🔨 Utility Scripts

- **sync-css.sh** — Bash script to sync CSS (Linux/Mac)
- **sync-css.ps1** — PowerShell script to sync CSS (Windows)

## 📦 Composer Files

- **composer.json** — PHP dependencies
- **composer.lock** — Locked dependency versions

## 🔐 Environment

- **.env** — Local environment config (not in git)
- **.env.example** — Example environment file

## 🚀 Entry Points

- **public/index.php** — Application entry point
- **artisan** — CLI entry point

## 📂 Storage Directories (Important)

```
storage/app/public/
├── products/       — Product images
├── categories/     — Category icons
├── posts/          — Blog post thumbnails
└── settings/       — Setting images (Zalo QR, etc.)
```

**Note**: Run `php artisan storage:link` to create symlink from `public/storage` to `storage/app/public`

## 🗂️ Public Assets

```
public/
├── css/            — Synced CSS files (14 files)
├── storage/        — Symlink to storage/app/public
└── index.php       — Entry point
```

## 📊 Key Statistics

| Category | Count |
|----------|-------|
| Routes | 74 |
| Controllers | 18 |
| Models | 10 |
| Services | 4 |
| Migrations | 10 |
| Seeders | 6 |
| Blade Views | 29 |
| CSS Files | 14 |
| Documentation Files | 4 |

## 🔍 Quick File Locations

### Need to edit...
- **Routes?** → `routes/web.php`
- **Database schema?** → `database/migrations/`
- **Business logic?** → `app/Services/`
- **Page layout?** → `resources/views/layouts/`
- **Styles?** → `resources/css/` (then run sync script)
- **Site settings?** → Admin panel or `database/seeders/SettingSeeder.php`

### Need to check...
- **Logs?** → `storage/logs/laravel.log`
- **Environment?** → `.env`
- **Routes list?** → `php artisan route:list`
- **Database?** → `php artisan db:show`

## 📝 Important Notes

1. **CSS Workflow**: Always edit in `resources/css/`, then run `bash sync-css.sh`
2. **No Registration**: Users can only be created by admin
3. **Order System**: Uses inquiries, not traditional orders
4. **Image Uploads**: Ensure storage directories exist and symlink is created
5. **Admin Access**: Requires `role = 'admin'` in users table
6. **Database**: MySQL/MariaDB required, database name: `flowershop`

---

**For detailed documentation, see**: `FLOWERSHOP.md`
**For commands, see**: `COMMANDS.md`
**For setup summary, see**: `SETUP_COMPLETE.md`
