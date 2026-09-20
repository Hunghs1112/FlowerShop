# 🎥 VIDEO FEATURE - QUICK REFERENCE

## 📍 URLs

### Admin
- **Edit Product:** `http://127.0.0.1:8000/admin/products/{id}/edit`
- **Upload Endpoint:** `POST /admin/products/{id}/upload-file`
- **Delete Endpoint:** `DELETE /admin/products/{id}/videos/{video_id}`

### Frontend
- **Product Detail:** `http://127.0.0.1:8000/products/{slug}`

## 🗂️ Key Files

```
database/migrations/
└── 2024_01_20_000003_add_video_support_to_product_images.php

app/Models/
└── ProductImage.php                    # scopes: images(), videos()

app/Http/Controllers/Admin/
└── ProductController.php               # uploadFile(), deleteVideo()

resources/views/
├── admin/products/form.blade.php       # Upload UI + Video List
└── products/detail.blade.php           # Video Player + Gallery

config/
└── upload.php                          # limits.product_videos

public/storage/products/videos/         # Video storage folder
```

## 🔧 Quick Commands

```bash
# Run test
./test-video-feature.sh

# Check routes
php artisan route:list | grep video

# Check database
php artisan tinker --execute="print_r(Schema::getColumnListing('product_images'));"

# Check config
php artisan tinker --execute="var_dump(config('upload.limits.product_videos'));"

# Clear cache
php artisan config:clear
php artisan view:clear
php artisan cache:clear

# Create storage link
php artisan storage:link

# Check migrations
php artisan migrate:status
```

## 💾 Database Schema

```sql
ALTER TABLE product_images ADD COLUMN media_type ENUM('image','video') DEFAULT 'image';
ALTER TABLE product_images ADD COLUMN mime_type VARCHAR(100);
ALTER TABLE product_images ADD COLUMN video_url VARCHAR(255) NULL;
ALTER TABLE product_images ADD COLUMN thumbnail_path VARCHAR(255) NULL;
```

## 🎯 Model Usage

```php
// Get all images
$product->productImages()->images()->get();

// Get all videos
$product->productImages()->videos()->get();

// Create video record
ProductImage::create([
    'product_id' => $product->id,
    'media_type' => 'video',
    'mime_type' => 'video/mp4',
    'video_url' => 'products/videos/abc123.mp4',
    'thumbnail_path' => null,
    'sort_order' => 1,
    'is_primary' => false,
]);

// Check if video
$media->media_type === 'video'
```

## 🌐 API Examples

### Upload Videos (AJAX)

```javascript
const formData = new FormData();
const files = document.getElementById('video-files').files;

for (let i = 0; i < files.length; i++) {
    formData.append('videos[]', files[i]);
}
formData.append('_token', '{{ csrf_token() }}');

fetch('/admin/products/{{ $product->id }}/upload-file', {
    method: 'POST',
    body: formData
})
.then(res => res.json())
.then(data => {
    if (data.success) {
        location.reload();
    }
});
```

### Delete Video (AJAX)

```javascript
fetch('/admin/products/{{ $product->id }}/videos/' + videoId, {
    method: 'DELETE',
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json'
    }
})
.then(res => res.json())
.then(data => {
    if (data.success) {
        document.getElementById('video-' + videoId).remove();
    }
});
```

## 🎨 Frontend Display

```javascript
// Switch to video
function changeMainMedia(type, url) {
    if (type === 'video') {
        document.getElementById('productImage').style.display = 'none';
        const videoEl = document.getElementById('productVideo');
        videoEl.src = '/storage/' + url;
        videoEl.style.display = 'block';
        videoEl.load();
    } else {
        document.getElementById('productVideo').style.display = 'none';
        document.getElementById('productImage').src = url;
        document.getElementById('productImage').style.display = 'block';
    }
}
```

## ⚙️ Configuration

```php
// config/upload.php
'limits' => [
    'product_videos' => [
        'max_size' => 51200,  // 50MB in KB
        'max_count' => 5,     // Max 5 videos per product
    ],
],
```

## 🔒 Security Checklist

- ✅ CSRF token in all requests
- ✅ Authorization check (user owns product)
- ✅ File type validation (mime_type)
- ✅ File size validation (max 50MB)
- ✅ Storage path sanitization
- ✅ No direct file path exposure to client

## 🐛 Common Issues

### Issue: Upload fails
```bash
# Check storage permissions
chmod -R 775 storage/
chown -R www-data:www-data storage/

# Check storage link
php artisan storage:link

# Check upload directory
mkdir -p storage/app/public/products/videos
```

### Issue: Video doesn't play
- Check mime_type in database
- Check video file exists in storage
- Check browser console for errors
- Verify video codec (H.264 recommended)

### Issue: Routes not found
```bash
php artisan route:clear
php artisan route:cache
php artisan route:list | grep video
```

## 📊 Monitoring

```bash
# Check storage usage
du -sh storage/app/public/products/videos/

# Count videos in database
php artisan tinker --execute="echo App\Models\ProductImage::videos()->count();"

# List recent uploads
php artisan tinker --execute="
App\Models\ProductImage::videos()
    ->latest()
    ->take(10)
    ->get(['id', 'product_id', 'video_url', 'created_at'])
    ->each(fn(\$v) => echo \$v->id . ': ' . \$v->video_url . PHP_EOL);
"
```

---

**Last Updated:** Sep 19, 2026
**Status:** Production Ready ✅
