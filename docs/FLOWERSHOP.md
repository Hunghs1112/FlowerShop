# FlowerShop — Project Documentation

## Tổng Quan Dự Án

**FlowerShop** là một nền tảng thương mại điện tử chuyên về hoa tươi và hoa nhập khẩu, được xây dựng trên Laravel 11 với Blade templating engine và MySQL database.

### Đặc Điểm Chính

- **Không có thanh toán online**: Đơn hàng được xử lý qua Zalo
- **Quản lý tài khoản**: Chỉ admin mới có thể tạo tài khoản khách hàng
- **Guest browsing**: Khách vãng lai có thể xem sản phẩm, nhưng cần đăng nhập để đặt hàng hoặc yêu thích
- **Inquiry-based ordering**: Thay vì quản lý đơn hàng truyền thống, hệ thống tạo yêu cầu liên hệ
- **Blog & Tips**: Bài viết về hoa mới, xu hướng, và tips hàng ngày

## Tech Stack

### Backend
- **Framework**: Laravel 11.x
- **PHP**: 8.2+
- **Database**: MySQL 8.0 / MariaDB 10.5+
- **Authentication**: Laravel built-in (without registration)

### Frontend
- **Templating**: Blade
- **CSS**: Custom CSS (no frameworks)
- **JavaScript**: Vanilla JS (minimal)
- **No build tools**: Direct CSS sync from resources to public

### Development Tools
- **CSS Sync**: Bash script (`sync-css.sh`) or PowerShell (`sync-css.ps1`)
- **Seeding**: Database seeders for initial data

## Project Structure

```
FlowerShop/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/                  # Authentication controllers
│   │   │   ├── Admin/                 # Admin panel controllers
│   │   │   ├── CartController.php     # Cart management
│   │   │   ├── CategoryController.php # Category pages
│   │   │   ├── CheckoutController.php # Checkout flow
│   │   │   ├── FavoriteController.php # Favorites
│   │   │   ├── HomeController.php     # Homepage
│   │   │   ├── PageController.php     # Static pages
│   │   │   ├── PostController.php     # Blog
│   │   │   ├── ProductController.php  # Products
│   │   │   ├── ProfileController.php  # User profile
│   │   │   └── QuickOrderController.php # Quick order
│   │   └── Middleware/
│   │       └── AdminMiddleware.php    # Admin access control
│   ├── Models/                        # Eloquent models
│   └── Services/                      # Business logic layer
│       ├── CartService.php
│       ├── CategoryService.php
│       ├── ProductService.php
│       └── SettingService.php
├── database/
│   ├── migrations/                    # Database schema
│   └── seeders/                       # Sample data
├── resources/
│   ├── css/                          # Source CSS files
│   │   ├── theme.css                 # CSS variables & base
│   │   ├── fonts.css                 # Typography
│   │   ├── navbar.css                # Navigation
│   │   ├── footer.css                # Footer
│   │   ├── home.css                  # Homepage
│   │   ├── hero.css                  # Hero section
│   │   ├── products.css              # Product pages
│   │   ├── blog.css                  # Blog pages
│   │   ├── auth.css                  # Login/auth
│   │   ├── account.css               # User account
│   │   ├── pages.css                 # Static pages
│   │   ├── checkout.css              # Cart & checkout
│   │   └── admin.css                 # Admin panel
│   └── views/
│       ├── layouts/                  # Base layouts
│       ├── partials/                 # Reusable components
│       ├── auth/                     # Auth views
│       ├── account/                  # User account views
│       ├── admin/                    # Admin panel views
│       └── [various page views]
├── routes/
│   └── web.php                       # All web routes
├── public/
│   └── css/                          # Compiled CSS (synced)
├── sync-css.sh                       # Linux/Mac CSS sync
├── sync-css.ps1                      # Windows CSS sync
└── FLOWERSHOP.md                     # This file
```

## Database Schema

### Users Table
```sql
- id (primary key)
- name (string)
- email (string, unique)
- phone (string, nullable)
- address (text, nullable)
- role (enum: 'admin', 'customer', default 'customer')
- is_active (boolean, default true)
- email_verified_at (timestamp, nullable)
- password (string)
- remember_token
- timestamps
```

### Categories Table
```sql
- id (primary key)
- parent_id (foreign key to categories, nullable)
- name (string)
- slug (string, unique)
- description (text, nullable)
- icon (string, nullable)
- sort_order (integer, default 0)
- is_active (boolean, default true)
- timestamps
```

### Products Table
```sql
- id (primary key)
- category_id (foreign key to categories)
- name (string)
- slug (string, unique)
- price (decimal 10,2)
- stock (integer, default 0)
- short_description (text, nullable)
- is_featured (boolean, default false)
- is_active (boolean, default true)
- timestamps
```

### Product Images Table
```sql
- id (primary key)
- product_id (foreign key to products, cascade delete)
- image_path (string)
- sort_order (integer, default 0)
- is_primary (boolean, default false)
- timestamps
```

### Cart Items Table
```sql
- id (primary key)
- user_id (foreign key to users, nullable, cascade delete)
- session_id (string, nullable)
- product_id (foreign key to products, cascade delete)
- quantity (integer, default 1)
- timestamps
```

### Inquiries Table
```sql
- id (primary key)
- user_id (foreign key to users, nullable, set null)
- name (string)
- phone (string)
- email (string, nullable)
- zalo_id (string, nullable)
- product_ids (json)
- message (text, nullable)
- status (enum: 'new', 'contacted', 'completed', 'cancelled', default 'new')
- timestamps
```

### Posts Table
```sql
- id (primary key)
- title (string)
- slug (string, unique)
- excerpt (text, nullable)
- content (longtext)
- thumbnail (string, nullable)
- is_published (boolean, default false)
- published_at (timestamp, nullable)
- timestamps
```

### Favorites Table
```sql
- id (primary key)
- user_id (foreign key to users, cascade delete)
- product_id (foreign key to products, cascade delete)
- timestamps
- unique constraint on (user_id, product_id)
```

### Pages Table
```sql
- id (primary key)
- title (string)
- slug (string, unique)
- content (longtext)
- is_active (boolean, default true)
- timestamps
```

### Settings Table
```sql
- id (primary key)
- key (string, unique)
- value (text, nullable)
- type (string, default 'text')
- timestamps
```

## Model Relationships

### User
- `hasMany` CartItems
- `hasMany` Favorites
- `hasMany` Inquiries

### Category
- `belongsTo` parent (Category)
- `hasMany` children (Categories)
- `hasMany` Products

### Product
- `belongsTo` Category
- `hasMany` ProductImages
- `hasMany` CartItems
- `hasMany` Favorites

### ProductImage
- `belongsTo` Product

### CartItem
- `belongsTo` User
- `belongsTo` Product

### Inquiry
- `belongsTo` User

### Favorite
- `belongsTo` User
- `belongsTo` Product

## Routes Overview

### Public Routes (Guest Access)
```
GET  /                           home
GET  /san-pham                   products.index
GET  /san-pham/{slug}            products.show
GET  /danh-muc                   categories.index
GET  /danh-muc/{slug}            categories.show
GET  /bai-viet                   blog.index
GET  /bai-viet/{slug}            blog.show
GET  /ve-chung-toi               about
GET  /lien-he                    contact
POST /lien-he                    contact.submit
GET  /trang/{slug}               policy (dynamic pages)
```

### Cart Routes (Guest + Auth)
```
GET    /gio-hang                cart.index
POST   /gio-hang/them           cart.add
PATCH  /gio-hang/{item}         cart.update
DELETE /gio-hang/{item}         cart.destroy
DELETE /gio-hang                cart.clear
POST   /dat-hang-nhanh          quick-order.store
```

### Authentication Routes (No Registration)
```
GET  /login                      login
POST /login                      (login)
POST /logout                     logout
GET  /password/reset             password.request
POST /password/email             password.email
GET  /password/reset/{token}     password.reset
POST /password/reset             password.update
```

### Authenticated User Routes
```
GET   /thanh-toan                checkout.index
POST  /thanh-toan                checkout.store
GET   /thanh-toan/thanh-cong     checkout.success
GET   /tai-khoan                 profile.show
PATCH /tai-khoan                 profile.update
PATCH /tai-khoan/mat-khau        profile.password
GET   /yeu-thich                 favorites.index
POST  /yeu-thich                 favorites.store
DELETE /yeu-thich/{favorite}     favorites.destroy
```

### Admin Routes (Auth + Admin Middleware)
```
GET    /admin                              admin.dashboard
CRUD   /admin/categories                   admin.categories.*
CRUD   /admin/products                     admin.products.*
GET    /admin/inquiries                    admin.inquiries.index
GET    /admin/inquiries/{id}               admin.inquiries.show
PATCH  /admin/inquiries/{id}/status        admin.inquiries.updateStatus
CRUD   /admin/posts                        admin.posts.*
CRUD   /admin/users                        admin.users.*
CRUD   /admin/pages                        admin.pages.*
GET    /admin/settings                     admin.settings.index
PUT    /admin/settings                     admin.settings.update
```

## CSS Architecture

### Design System Principles

FlowerShop sử dụng custom CSS với CSS Custom Properties (variables) để duy trì tính nhất quán.

### CSS Custom Properties (theme.css)

#### Colors
```css
--color-primary: #0F172A;      /* Deep slate */
--color-secondary: #38BDF8;    /* Sky blue */
--color-accent: #F97316;       /* Orange */
--color-success: #10B981;      /* Green */
--color-warning: #F59E0B;      /* Amber */
--color-error: #EF4444;        /* Red */
--color-text-primary: #F8FAFC; /* Off-white */
--color-text-secondary: #CBD5E1; /* Light slate */
--color-background: #0B0E14;   /* Near black */
--color-surface: #1E293B;      /* Dark slate */
--color-border: #334155;       /* Medium slate */
```

#### Spacing
```css
--space-xs: 0.25rem;  /* 4px */
--space-sm: 0.5rem;   /* 8px */
--space-md: 1rem;     /* 16px */
--space-lg: 1.5rem;   /* 24px */
--space-xl: 2rem;     /* 32px */
--space-2xl: 3rem;    /* 48px */
--space-3xl: 4rem;    /* 64px */
```

#### Typography
```css
--font-sans: 'Inter', system-ui, sans-serif;
--font-mono: 'IBM Plex Mono', monospace;

--text-xs: clamp(0.75rem, 0.7rem + 0.25vw, 0.875rem);
--text-sm: clamp(0.875rem, 0.8rem + 0.375vw, 1rem);
--text-base: clamp(1rem, 0.9rem + 0.5vw, 1.125rem);
--text-lg: clamp(1.125rem, 1rem + 0.625vw, 1.25rem);
--text-xl: clamp(1.25rem, 1.1rem + 0.75vw, 1.5rem);
--text-2xl: clamp(1.5rem, 1.3rem + 1vw, 2rem);
--text-3xl: clamp(2rem, 1.7rem + 1.5vw, 2.5rem);
--text-4xl: clamp(2.5rem, 2rem + 2.5vw, 3.5rem);
```

#### Shadows
```css
--shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.3);
--shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.4);
--shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.5);
--shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.6);
```

#### Border Radius
```css
--radius-sm: 4px;
--radius-md: 8px;
--radius-lg: 12px;
--radius-xl: 16px;
--radius-full: 9999px;
```

### Responsive Breakpoints
```css
--breakpoint-sm: 640px;
--breakpoint-md: 768px;
--breakpoint-lg: 1024px;
--breakpoint-xl: 1280px;
```

### File Organization

1. **theme.css** — Base variables, reset, utilities
2. **fonts.css** — Font imports and typography utilities
3. **navbar.css** — Navigation bar styles
4. **footer.css** — Footer styles
5. **home.css** — Homepage sections
6. **hero.css** — Hero banner
7. **products.css** — Product listing and detail pages
8. **blog.css** — Blog listing and post pages
9. **auth.css** — Login and authentication pages
10. **account.css** — User account pages
11. **pages.css** — Static content pages
12. **checkout.css** — Cart and checkout pages
13. **admin.css** — Admin panel styles

### CSS Sync Workflow

After editing any CSS file in `resources/css/`:

**Linux/Mac:**
```bash
bash sync-css.sh
```

**Windows:**
```powershell
.\sync-css.ps1
```

This copies all CSS files from `resources/css/` to `public/css/`.

## Development Workflow

### Initial Setup

1. Clone/create project
2. Copy `.env.example` to `.env`
3. Configure database credentials
4. Install dependencies:
   ```bash
   composer install
   ```
5. Generate app key:
   ```bash
   php artisan key:generate
   ```
6. Run migrations:
   ```bash
   php artisan migrate
   ```
7. Run seeders:
   ```bash
   php artisan db:seed
   ```
8. Sync CSS files:
   ```bash
   bash sync-css.sh
   ```
9. Start development server:
   ```bash
   php artisan serve
   ```

### Default Admin Account

After seeding, use these credentials:
- **Email**: `admin@flowershop.local`
- **Password**: `password123`

### Common Tasks

#### Create New Product
1. Login as admin
2. Navigate to `/admin/products/create`
3. Fill form (name, category, price, images)
4. Submit

#### Create Customer Account
1. Login as admin
2. Navigate to `/admin/users/create`
3. Fill customer details
4. Set role to "customer"
5. Submit

#### Update Site Settings
1. Login as admin
2. Navigate to `/admin/settings`
3. Edit settings (site info, contact, social, Zalo)
4. Upload Zalo QR if needed
5. Save

#### Manage Inquiries
1. Login as admin
2. Navigate to `/admin/inquiries`
3. View inquiry details
4. Update status (new → contacted → completed/cancelled)
5. Contact customer via Zalo

### CSS Development

1. Edit files in `resources/css/`
2. Run sync script: `bash sync-css.sh`
3. Refresh browser
4. Repeat as needed

**Note**: No build process required. Direct CSS serving.

## Service Layer

### CartService
Handles shopping cart logic for both authenticated and guest users.

**Methods:**
- `getCartIdentifier()` — Get user ID or session ID
- `getCartItems()` — Retrieve cart items
- `addItem($productId, $quantity)` — Add product to cart
- `updateQuantity($cartItemId, $quantity)` — Update item quantity
- `removeItem($cartItemId)` — Remove item from cart
- `clearCart()` — Empty cart
- `getTotal()` — Calculate cart total
- `getItemsCount()` — Get total items count
- `mergeGuestCart($userId)` — Merge guest cart after login

### CategoryService
Manages category operations and hierarchical structure.

**Methods:**
- `getActiveCategories()` — Get all active categories
- `getCategoryTree()` — Build hierarchical category tree
- `getBreadcrumb($category)` — Generate breadcrumb trail
- `getDescendantIds($categoryId)` — Get all descendant category IDs

### ProductService
Handles product filtering, search, and recommendations.

**Methods:**
- `getFeaturedProducts($limit)` — Get featured products
- `filterProducts($filters)` — Filter products by various criteria
- `getRelatedProducts($product, $limit)` — Get related products
- `search($query)` — Search products by name

### SettingService
Manages site-wide settings with caching.

**Methods:**
- `get($key, $default)` — Get single setting
- `set($key, $value, $type)` — Set single setting
- `getMultiple($keys)` — Get multiple settings
- `getAll()` — Get all settings
- `updateMultiple($settings)` — Update multiple settings
- `clearCache()` — Clear settings cache
- `getSiteInfo()` — Get common site info (name, tagline, etc.)

## Business Logic

### Order Flow

FlowerShop không sử dụng hệ thống đặt hàng truyền thống. Thay vào đó:

1. **Guest/User browses products**
2. **Adds to cart** (session-based for guests, user-based for auth)
3. **Proceeds to checkout** (must login)
4. **Fills contact form** (name, phone, email, Zalo ID, message)
5. **System creates Inquiry** (not Order)
6. **Redirects to success page** with Zalo contact info
7. **Admin views inquiry** in admin panel
8. **Admin contacts customer** via Zalo
9. **Admin updates inquiry status** (new → contacted → completed)

### Quick Order

Alternative flow for single products:

1. **User clicks "Quick Order" on product page**
2. **Modal opens** with contact form
3. **User fills form** (no cart involved)
4. **System creates Inquiry** for that single product
5. **Admin follows up** via Zalo

### Guest Cart Handling

- Cart stored in **session** for guests
- Upon login, **merges guest cart** into user's cart
- Session cart cleared after merge

### Favorites

- **Auth required** for favorites
- User can favorite/unfavorite products
- View all favorites in `/yeu-thich`

## Admin Features

### Dashboard
- Total products, categories, users, inquiries counts
- Recent inquiries list
- Low stock products alert

### Category Management
- CRUD operations
- Hierarchical structure (parent/child)
- Icon upload
- Sort order control

### Product Management
- CRUD operations
- Multiple image upload
- Primary image selection
- Stock management
- Featured product flag

### Inquiry Management
- List all inquiries (filterable by status)
- View inquiry details (customer info, products, message)
- Update status (new/contacted/completed/cancelled)
- **No order processing** — just view and contact

### User Management
- Admin creates customer accounts
- Edit user details
- Activate/deactivate users
- **No self-registration**

### Post Management
- CRUD blog posts
- Publish/unpublish
- Thumbnail upload
- Rich text content

### Page Management
- CRUD static pages (policies, terms, etc.)
- Activate/deactivate pages

### Settings Management
- Site info (name, tagline, description)
- Contact info (phone, email, address)
- Social media links
- Zalo info and QR code upload

## Security Features

### AdminMiddleware
Restricts admin routes to users with `role = 'admin'`.

### Authentication
- Laravel built-in auth (without registration)
- Password reset via email
- Remember me functionality

### Authorization
- Admin-only routes protected by middleware
- User can only edit own profile
- Guest cart isolation by session

### Input Validation
- All form requests validated
- CSRF protection enabled
- XSS protection via Blade escaping

## Future Enhancements

### Phase 2 — Design Implementation
- Implement full design based on provided template
- Refine colors, fonts, spacing
- Add animations and micro-interactions
- Polish responsive behavior

### Phase 3 — Advanced Features
- Product search with autocomplete
- Advanced filtering (price range, color, type)
- Wishlist sharing
- Email notifications for inquiries
- Image optimization and lazy loading
- SEO meta tags and structured data

### Phase 4 — Analytics
- Track popular products
- View counts and analytics
- Admin analytics dashboard

### Phase 5 — Content Management
- WYSIWYG editor for posts/pages
- Media library
- Bulk product import

## Testing

### Manual Testing Checklist

#### Public Features
- [ ] Homepage loads with featured products
- [ ] Product listing and filtering
- [ ] Product detail page
- [ ] Category navigation
- [ ] Add to cart (guest and auth)
- [ ] Cart operations (update, remove, clear)
- [ ] Login/logout
- [ ] Password reset
- [ ] Checkout flow
- [ ] Quick order
- [ ] Favorites (auth required)
- [ ] User profile edit
- [ ] Blog listing and post view
- [ ] Static pages (about, contact, policies)

#### Admin Features
- [ ] Admin login with correct role
- [ ] Dashboard statistics
- [ ] Category CRUD
- [ ] Product CRUD with images
- [ ] Inquiry list and detail
- [ ] Inquiry status update
- [ ] Post CRUD
- [ ] User CRUD
- [ ] Page CRUD
- [ ] Settings update

### Database Testing
```bash
# Reset and reseed database
php artisan migrate:fresh --seed
```

### Route Testing
```bash
# List all routes
php artisan route:list --except-vendor
```

## Troubleshooting

### CSS Not Loading
1. Check if CSS files exist in `public/css/`
2. Run sync script: `bash sync-css.sh`
3. Clear browser cache
4. Check layout includes correct CSS files

### Database Connection Error
1. Verify `.env` database credentials
2. Ensure MySQL/MariaDB is running
3. Create database if not exists:
   ```sql
   CREATE DATABASE flowershop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

### 403 Forbidden on Admin Routes
1. Verify user has `role = 'admin'`
2. Check AdminMiddleware is registered
3. Ensure auth middleware applied

### Cart Not Working for Guests
1. Check session configuration in `.env`
2. Ensure `SESSION_DRIVER=file` or `database`
3. Clear Laravel cache: `php artisan cache:clear`

### Images Not Displaying
1. Create `storage/app/public/` subdirectories:
   ```bash
   mkdir -p storage/app/public/{products,categories,posts,settings}
   ```
2. Create symlink:
   ```bash
   php artisan storage:link
   ```
3. Check file permissions

## Deployment Notes

### Production Checklist
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Generate new `APP_KEY`
- [ ] Configure production database
- [ ] Set proper file permissions
- [ ] Create storage symlink
- [ ] Run migrations
- [ ] Seed initial data
- [ ] Sync CSS files
- [ ] Configure web server (Nginx/Apache)
- [ ] Set up SSL certificate
- [ ] Configure email service for password reset

### Server Requirements
- PHP 8.2+
- MySQL 8.0+ or MariaDB 10.5+
- Composer
- Web server (Nginx/Apache)
- SSL certificate

---

**Project**: FlowerShop  
**Framework**: Laravel 11  
**Created**: September 2026  
**Documentation Version**: 1.0
