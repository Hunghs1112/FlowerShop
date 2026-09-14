# 多语言（双语）功能优化文档

## 概述
本项目支持越南语（vi）和英语（en）双语切换功能。已完成全面优化，确保语言切换按钮正常工作。

## 核心功能

### 1. 语言检测优先级
在 `App\Http\Middleware\SetLocale` 中实现，按以下顺序检测语言：
1. **URL 前缀** (如 `/vi/san-pham` → `vi`) - 最高优先级
2. **Session 语言** - 用户之前选择的语言
3. **浏览器语言** - 从 Accept-Language 头自动检测
4. **默认语言** - 越南语 (vi)

### 2. 路由结构
所有面向客户的路由都在 `{locale}` 前缀下：

```php
// routes/web.php
Route::prefix('{locale}')->where(['locale' => 'vi|en'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/san-pham', [ProductController::class, 'index'])->name('products.index');
    // ... 其他路由
});
```

### 3. 辅助函数

#### `locale_route()` - 自动注入语言参数
替代 Laravel 的 `route()` 函数，自动添加当前语言参数。

**用法示例：**
```blade
{{-- 旧方式（错误）--}}
<a href="{{ route('home') }}">首页</a>  {{-- 会报错：缺少 locale 参数 --}}

{{-- 新方式（正确）--}}
<a href="{{ locale_route('home') }}">首页</a>  {{-- 自动生成：/vi --}}
<a href="{{ locale_route('products.show', $product) }}">产品</a>  {{-- 自动生成：/vi/san-pham/{slug} --}}
```

#### `localized_url()` - 生成切换语言的 URL
用于语言切换按钮，保持当前页面路径和查询参数，只替换语言前缀。

**工作原理：**
```php
// 当前页面：/vi/san-pham?sort=newest
localized_url('en')  // 返回：/en/san-pham?sort=newest

// 当前页面：/vi/bai-viet/laravel-tips
localized_url('en')  // 返回：/en/bai-viet/laravel-tips
```

### 4. 语言切换组件
**位置：** `resources/views/components/language-switcher.blade.php`

**特性：**
- 显示当前语言的对应国旗和语言代码
- 点击切换到另一种语言
- 保持当前页面路径和查询参数
- 响应式设计（移动端优化）

**使用方法：**
```blade
<x-language-switcher />
```

### 5. 语言切换控制器（可选）
**位置：** `app/Http/Controllers/LocaleController.php`

提供专门的路由处理语言切换：
```
GET /locale/{locale}
```

该控制器会：
1. 验证语言是否支持
2. 保存语言到 Session
3. 从 referer 提取路径并替换语言前缀
4. 重定向到对应页面

## 已修复的文件

### 视图文件（Blade）
所有使用 `route('home')` 的文件已改为 `locale_route('home')`：

✅ `resources/views/blog/index.blade.php`
✅ `resources/views/pages/about.blade.php`
✅ `resources/views/pages/contact.blade.php`
✅ `resources/views/pages/policy.blade.php`
✅ `resources/views/profile/show.blade.php`
✅ `resources/views/cart/index.blade.php`
✅ `resources/views/checkout/index.blade.php`
✅ `resources/views/partials/navbar-old.blade.php`

### 核心文件
✅ `app/Helpers.php` - 辅助函数定义
✅ `app/Providers/AppServiceProvider.php` - 辅助函数定义（备份）
✅ `routes/web.php` - 添加语言切换路由
✅ `composer.json` - 自动加载 Helpers.php

## 使用指南

### 在视图中使用

#### 1. 生成路由链接
```blade
{{-- 首页 --}}
<a href="{{ locale_route('home') }}">Home</a>

{{-- 产品列表 --}}
<a href="{{ locale_route('products.index') }}">Products</a>

{{-- 产品详情 --}}
<a href="{{ locale_route('products.show', $product) }}">View Product</a>

{{-- 带查询参数 --}}
<a href="{{ locale_route('products.index', ['sort_by' => 'newest']) }}">New Products</a>

{{-- 分类详情 --}}
<a href="{{ locale_route('categories.show', $category->slug) }}">Category</a>
```

#### 2. 表单提交
```blade
<form action="{{ locale_route('contact.submit') }}" method="POST">
    @csrf
    {{-- 表单字段 --}}
</form>
```

#### 3. 语言切换按钮
```blade
{{-- 在导航栏中 --}}
<div class="navbar-actions">
    <x-language-switcher />
</div>
```

### 在控制器中使用

```php
// 重定向到其他页面
return redirect()->route('home', ['locale' => app()->getLocale()]);

// 或使用 locale_route() 辅助函数
return redirect(locale_route('products.index'));
```

## 支持的路由列表

以下路由需要使用 `locale_route()` 而非 `route()`：

**核心页面：**
- `home`
- `about`
- `contact`
- `contact.submit`
- `policy`

**产品相关：**
- `products.index`
- `products.show`
- `categories.index`
- `categories.show`

**博客：**
- `blog.index`
- `blog.show`

**购物车和结账：**
- `cart.index`, `cart.add`, `cart.update`, `cart.destroy`, `cart.clear`
- `checkout.index`, `checkout.store`, `checkout.success`

**用户认证：**
- `login`, `logout`
- `password.request`, `password.email`, `password.reset`, `password.update`

**用户资料：**
- `profile.show`, `profile.update`, `profile.password`

**快速下单：**
- `quick-order.store`

## 管理后台路由

管理后台路由（`admin.*`）**不需要**语言前缀，直接使用 `route()`：

```blade
<a href="{{ route('admin.dashboard') }}">Dashboard</a>
<a href="{{ route('admin.products.index') }}">Manage Products</a>
```

## 测试清单

- [x] 语言切换按钮显示正确的国旗和代码
- [x] 点击语言切换按钮可以正常切换语言
- [x] 切换语言后保持在相同页面
- [x] 查询参数在语言切换后保留
- [x] 所有客户端路由使用 `locale_route()`
- [x] 导航栏链接正常工作
- [x] 面包屑导航正常工作
- [x] 分页链接包含语言参数
- [x] 表单提交到正确的语言路径

## 故障排除

### 问题：Missing required parameter for [Route: xxx] [URI: {locale}]
**原因：** 使用了 `route()` 而不是 `locale_route()`
**解决：** 将 `route('xxx')` 改为 `locale_route('xxx')`

### 问题：语言切换按钮不工作
**解决步骤：**
1. 清除缓存：`php artisan route:clear && php artisan view:clear`
2. 重新生成自动加载：`composer dump-autoload`
3. 检查浏览器控制台是否有 JavaScript 错误

### 问题：切换语言后跳转到首页
**原因：** `localized_url()` 函数无法识别当前路由
**解决：** 已优化函数逻辑，现在会保持当前路径

## 性能优化

1. **Session 缓存** - 语言选择存储在 Session 中，避免每次请求都检测
2. **中间件优化** - `SetLocale` 中间件只在必要时更新语言
3. **视图共享** - 当前语言通过 `AppServiceProvider` 共享给所有视图

## 未来扩展

如需添加更多语言（如中文、韩语等）：

1. 在 `SetLocale` 中间件的 `$supportedLocales` 数组添加语言代码
2. 在 `routes/web.php` 中更新路由约束：`->where(['locale' => 'vi|en|zh|ko'])`
3. 添加对应的翻译文件到 `lang/{locale}/` 目录
4. 更新 `language-switcher.blade.php` 组件以支持多语言选择器

## 总结

双语功能已完全优化并测试通过。所有客户端路由都正确使用 `locale_route()` 辅助函数，语言切换按钮工作正常，用户体验流畅。
