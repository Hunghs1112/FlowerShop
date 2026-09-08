# FlowerShop — Quick Commands Reference

## Development Server

```bash
# Start Laravel development server
php artisan serve

# Start on specific port
php artisan serve --port=8080

# Start on specific host
php artisan serve --host=0.0.0.0
```

## CSS Workflow

```bash
# Sync CSS files (Linux/Mac)
bash sync-css.sh

# Sync CSS files (Windows)
.\sync-css.ps1

# Watch and auto-sync CSS (manual - create your own watcher if needed)
while inotifywait -e modify resources/css/*.css; do bash sync-css.sh; done
```

## Database Commands

```bash
# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Reset database and run all migrations
php artisan migrate:fresh

# Reset and seed
php artisan migrate:fresh --seed

# Run seeders only
php artisan db:seed

# Run specific seeder
php artisan db:seed --class=ProductSeeder

# Show database info
php artisan db:show

# Show table info
php artisan db:table users
```

## Cache Management

```bash
# Clear all caches
php artisan optimize:clear

# Clear application cache
php artisan cache:clear

# Clear config cache
php artisan config:clear

# Clear route cache
php artisan route:clear

# Clear view cache
php artisan view:clear

# Cache config
php artisan config:cache

# Cache routes
php artisan route:cache
```

## Routes & Controllers

```bash
# List all routes
php artisan route:list

# List routes without vendor
php artisan route:list --except-vendor

# Filter routes by name
php artisan route:list --name=admin

# Create controller
php artisan make:controller ProductController

# Create resource controller
php artisan make:controller ProductController --resource

# Create controller in subdirectory
php artisan make:controller Admin/ProductController
```

## Models & Migrations

```bash
# Create model
php artisan make:model Product

# Create model with migration
php artisan make:model Product -m

# Create model with migration, factory, seeder
php artisan make:model Product -mfs

# Create migration
php artisan make:migration create_products_table

# Create migration for existing table
php artisan make:migration add_column_to_products_table
```

## Seeders

```bash
# Create seeder
php artisan make:seeder ProductSeeder

# Run all seeders
php artisan db:seed

# Run specific seeder
php artisan db:seed --class=ProductSeeder
```

## Tinker (Interactive Shell)

```bash
# Start tinker
php artisan tinker

# Quick queries
php artisan tinker --execute="App\Models\User::count()"
php artisan tinker --execute="App\Models\Product::where('is_active', true)->count()"
```

### Common Tinker Commands

```php
// Inside tinker session

// Get all users
User::all();

// Find user by ID
User::find(1);

// Create new user
User::create(['name' => 'Test', 'email' => 'test@example.com', 'password' => bcrypt('password')]);

// Update user
$user = User::find(1);
$user->name = 'New Name';
$user->save();

// Delete user
User::find(1)->delete();

// Get products with category
Product::with('category')->get();

// Count active products
Product::where('is_active', true)->count();
```

## Storage & Symlinks

```bash
# Create storage symlink
php artisan storage:link

# Create directories for uploads
mkdir -p storage/app/public/products
mkdir -p storage/app/public/categories
mkdir -p storage/app/public/posts
mkdir -p storage/app/public/settings
```

## Maintenance Mode

```bash
# Enable maintenance mode
php artisan down

# Enable with secret bypass
php artisan down --secret="bypass-token"

# Disable maintenance mode
php artisan up
```

## Queue Management

```bash
# Start queue worker
php artisan queue:work

# Process one job
php artisan queue:work --once

# Start queue with specific connection
php artisan queue:work database

# List failed jobs
php artisan queue:failed

# Retry all failed jobs
php artisan queue:retry all
```

## Testing

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/ProductTest.php

# Run tests with coverage
php artisan test --coverage
```

## Git Workflow

```bash
# Check status
git status

# Add files
git add .

# Commit
git commit -m "Add product management"

# Push to remote
git push origin main

# Pull from remote
git pull origin main

# Create branch
git checkout -b feature/new-feature

# Switch branch
git checkout main

# Merge branch
git merge feature/new-feature
```

## Project Maintenance

```bash
# Update dependencies
composer update

# Install dependencies
composer install

# Dump autoload
composer dump-autoload

# Generate app key
php artisan key:generate

# Clear compiled files
php artisan clear-compiled

# Optimize for production
php artisan optimize
```

## Logs

```bash
# View Laravel log
tail -f storage/logs/laravel.log

# View last 100 lines
tail -n 100 storage/logs/laravel.log

# Clear log
> storage/logs/laravel.log
```

## File Permissions (Linux)

```bash
# Set proper permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# For development (less secure but easier)
chmod -R 777 storage bootstrap/cache
```

## Quick Debugging

```bash
# Enable debug mode
# Edit .env: APP_DEBUG=true

# Disable debug mode (production)
# Edit .env: APP_DEBUG=false

# Check environment
php artisan env

# Show app info
php artisan about
```

## Admin Panel Access

**URL**: http://localhost:8000/admin

**Credentials**:
- Email: `admin@flowershop.local`
- Password: `password123`

## Common Admin Tasks

```bash
# Create new admin user via tinker
php artisan tinker --execute="User::create(['name' => 'Admin', 'email' => 'admin@example.com', 'password' => bcrypt('password'), 'role' => 'admin', 'is_active' => true]);"

# Reset admin password
php artisan tinker --execute="\$user = User::where('email', 'admin@flowershop.local')->first(); \$user->password = bcrypt('newpassword'); \$user->save();"

# Check admin users
php artisan tinker --execute="User::where('role', 'admin')->get(['id', 'name', 'email']);"
```

## Database Backup

```bash
# Backup database
mysqldump -u root -p flowershop > backup_$(date +%Y%m%d_%H%M%S).sql

# Restore database
mysql -u root -p flowershop < backup_20260907_123456.sql
```

## Production Deployment

```bash
# 1. Pull latest code
git pull origin main

# 2. Install dependencies
composer install --no-dev --optimize-autoloader

# 3. Clear and cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 4. Run migrations
php artisan migrate --force

# 5. Sync CSS
bash sync-css.sh

# 6. Set permissions
chmod -R 775 storage bootstrap/cache

# 7. Restart queue workers (if using queues)
php artisan queue:restart
```

## Quick Health Check

```bash
# Check database connection
php artisan db:show

# Check routes
php artisan route:list --except-vendor | wc -l

# Check models
find app/Models -name "*.php" | wc -l

# Check views
find resources/views -name "*.blade.php" | wc -l

# Check CSS files
find public/css -name "*.css" | wc -l

# Check data counts
php artisan tinker --execute="echo 'Users: ' . User::count() . PHP_EOL; echo 'Products: ' . Product::count() . PHP_EOL; echo 'Categories: ' . Category::count() . PHP_EOL;"
```

## Useful Aliases (Add to ~/.bashrc or ~/.zshrc)

```bash
# Laravel aliases
alias pa='php artisan'
alias pas='php artisan serve'
alias pam='php artisan migrate'
alias pamf='php artisan migrate:fresh --seed'
alias pac='php artisan cache:clear'
alias par='php artisan route:list --except-vendor'
alias pat='php artisan tinker'

# Sync CSS
alias sync='bash sync-css.sh'

# Git aliases
alias gs='git status'
alias ga='git add .'
alias gc='git commit -m'
alias gp='git push'
alias gl='git log --oneline -10'
```

---

**Quick Start**: `php artisan serve` → http://localhost:8000
**Admin Panel**: http://localhost:8000/admin (admin@flowershop.local / password123)
**CSS Changes**: `bash sync-css.sh` after editing files in `resources/css/`
