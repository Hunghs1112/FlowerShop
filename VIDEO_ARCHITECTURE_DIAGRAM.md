# 🎥 VIDEO FEATURE - ARCHITECTURE DIAGRAM

## 📐 System Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                        FLOWERSHOP VIDEO SYSTEM                  │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│                          FRONTEND LAYER                         │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  ┌──────────────────────┐      ┌──────────────────────┐       │
│  │   Admin Upload UI    │      │  Public Detail Page  │       │
│  │                      │      │                      │       │
│  │  • File Input        │      │  • Video Player      │       │
│  │  • Progress Bar      │      │  • Gallery Thumbs    │       │
│  │  • Video List        │      │  • Media Switcher    │       │
│  │  • Delete Button     │      │  • Play Icon         │       │
│  └──────────────────────┘      └──────────────────────┘       │
│           │                              │                      │
│           │ AJAX POST/DELETE            │ GET                 │
│           ▼                              ▼                      │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│                          ROUTES LAYER                           │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  POST   /admin/products/{id}/upload-file                       │
│         → ProductController@uploadFile                          │
│                                                                 │
│  DELETE /admin/products/{id}/videos/{video}                    │
│         → ProductController@deleteVideo                         │
│                                                                 │
│  GET    /products/{slug}                                       │
│         → ProductController@show                                │
│                                                                 │
│  Middleware: auth, admin (for admin routes)                    │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│                        CONTROLLER LAYER                         │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  ProductController                                             │
│  ┌────────────────────────────────────────────────────┐       │
│  │  uploadFile($request, $product)                    │       │
│  │    1. Validate files (mime, size)                  │       │
│  │    2. Store files to disk                          │       │
│  │    3. Create ProductImage records                  │       │
│  │    4. Return JSON response                         │       │
│  └────────────────────────────────────────────────────┘       │
│                                                                 │
│  ┌────────────────────────────────────────────────────┐       │
│  │  deleteVideo($product, $video)                     │       │
│  │    1. Check authorization                          │       │
│  │    2. Delete file from disk                        │       │
│  │    3. Delete database record                       │       │
│  │    4. Return JSON response                         │       │
│  └────────────────────────────────────────────────────┘       │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│                          MODEL LAYER                            │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  ProductImage Model                                            │
│  ┌────────────────────────────────────────────────────┐       │
│  │  Fillable Fields:                                  │       │
│  │    - media_type, mime_type                         │       │
│  │    - video_url, thumbnail_path                     │       │
│  │    - product_id, sort_order, is_primary            │       │
│  └────────────────────────────────────────────────────┘       │
│                                                                 │
│  ┌────────────────────────────────────────────────────┐       │
│  │  Scopes:                                           │       │
│  │    - images() → WHERE media_type = 'image'         │       │
│  │    - videos() → WHERE media_type = 'video'         │       │
│  └────────────────────────────────────────────────────┘       │
│                                                                 │
│  ┌────────────────────────────────────────────────────┐       │
│  │  Relationships:                                    │       │
│  │    - belongsTo(Product)                            │       │
│  └────────────────────────────────────────────────────┘       │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│                         DATABASE LAYER                          │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  Table: product_images                                         │
│  ┌────────────────────────────────────────────────────┐       │
│  │  id              BIGINT UNSIGNED PRIMARY KEY       │       │
│  │  product_id      BIGINT UNSIGNED FOREIGN KEY       │       │
│  │  image_path      VARCHAR(255)                      │       │
│  │  media_type      ENUM('image','video')             │       │
│  │  mime_type       VARCHAR(100)                      │       │
│  │  video_url       VARCHAR(255) NULLABLE             │       │
│  │  thumbnail_path  VARCHAR(255) NULLABLE             │       │
│  │  sort_order      INT DEFAULT 0                     │       │
│  │  is_primary      BOOLEAN DEFAULT FALSE             │       │
│  │  created_at      TIMESTAMP                         │       │
│  │  updated_at      TIMESTAMP                         │       │
│  └────────────────────────────────────────────────────┘       │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│                         STORAGE LAYER                           │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  Disk: public (Laravel Storage)                                │
│  ┌────────────────────────────────────────────────────┐       │
│  │  storage/app/public/products/videos/               │       │
│  │    ├── abc123def456.mp4                            │       │
│  │    ├── xyz789ghi012.mp4                            │       │
│  │    └── ...                                         │       │
│  └────────────────────────────────────────────────────┘       │
│                                                                 │
│  Symlink: public/storage → storage/app/public                 │
│  Public URL: /storage/products/videos/{filename}               │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│                        CONFIGURATION                            │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  config/upload.php                                             │
│  ┌────────────────────────────────────────────────────┐       │
│  │  'limits' => [                                     │       │
│  │      'product_videos' => [                         │       │
│  │          'max_size' => 51200,  // 50MB             │       │
│  │          'max_count' => 5,                         │       │
│  │      ],                                            │       │
│  │  ],                                                │       │
│  │  'disks' => [                                      │       │
│  │      'folders' => [                                │       │
│  │          'video' => 'products/videos',             │       │
│  │      ],                                            │       │
│  │  ],                                                │       │
│  └────────────────────────────────────────────────────┘       │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

## 🔄 Data Flow Diagrams

### Upload Flow

```
User (Admin)
    │
    │ 1. Select video files
    ▼
┌─────────────────┐
│  Upload Form    │
│  (Blade View)   │
└─────────────────┘
    │
    │ 2. Click Upload Button
    │ 3. JavaScript: uploadVideos()
    │ 4. AJAX POST with FormData
    ▼
┌─────────────────────────┐
│  Route Middleware       │
│  - auth                 │
│  - admin                │
│  - CSRF verification    │
└─────────────────────────┘
    │
    │ 5. Pass to controller
    ▼
┌──────────────────────────────────┐
│  ProductController@uploadFile    │
│                                  │
│  6. Validate:                    │
│     - mime types (video/*)       │
│     - max size (50MB)            │
│     - max count (5)              │
│                                  │
│  7. Store each file:             │
│     - Generate unique name       │
│     - Save to disk               │
│                                  │
│  8. Create DB records:           │
│     ProductImage::create([       │
│       'media_type' => 'video',   │
│       'mime_type' => $mime,      │
│       'video_url' => $path,      │
│       ...                        │
│     ])                           │
│                                  │
│  9. Return JSON response         │
└──────────────────────────────────┘
    │
    │ 10. Success response
    ▼
┌─────────────────┐
│  JavaScript     │
│  - Hide progress│
│  - Reload page  │
└─────────────────┘
    │
    │ 11. Page refreshed
    ▼
┌─────────────────┐
│  Videos shown   │
│  in list        │
└─────────────────┘
```

### Delete Flow

```
User (Admin)
    │
    │ 1. Click Delete Button
    ▼
┌─────────────────┐
│  Confirm Dialog │
└─────────────────┘
    │
    │ 2. Confirm = Yes
    │ 3. JavaScript: deleteProductVideo()
    │ 4. AJAX DELETE request
    ▼
┌─────────────────────────┐
│  Route Middleware       │
│  - auth                 │
│  - admin                │
│  - CSRF verification    │
└─────────────────────────┘
    │
    │ 5. Pass to controller
    ▼
┌──────────────────────────────────┐
│  ProductController@deleteVideo   │
│                                  │
│  6. Find video record            │
│                                  │
│  7. Check authorization:         │
│     if (product.user_id != auth) │
│         return 403               │
│                                  │
│  8. Delete file from disk:       │
│     Storage::delete($video_url)  │
│                                  │
│  9. Delete DB record:            │
│     $video->delete()             │
│                                  │
│  10. Return JSON response        │
└──────────────────────────────────┘
    │
    │ 11. Success response
    ▼
┌─────────────────┐
│  JavaScript     │
│  - Remove DOM   │
│  - Show message │
└─────────────────┘
```

### Display Flow (Frontend)

```
User (Customer)
    │
    │ 1. Visit product detail page
    ▼
┌────────────────────────────┐
│  ProductController@show    │
│                            │
│  2. Load product:          │
│     $product->load([       │
│       'productImages',     │
│     ])                     │
│                            │
│  3. Pass to view           │
└────────────────────────────┘
    │
    │ 4. Render view
    ▼
┌────────────────────────────────┐
│  Blade View                    │
│                                │
│  5. Loop images:               │
│     @foreach images()          │
│       <img thumbnail>          │
│                                │
│  6. Loop videos:               │
│     @foreach videos()          │
│       <video thumbnail>        │
│       <play icon overlay>      │
│                                │
│  7. Main player area:          │
│     <video id="productVideo">  │
└────────────────────────────────┘
    │
    │ 8. User clicks video thumb
    │ 9. JavaScript: changeMainMedia('video', url)
    ▼
┌────────────────────────────┐
│  Update DOM                │
│  - Hide image              │
│  - Show video player       │
│  - Set video src           │
│  - Load & play             │
└────────────────────────────┘
```

## 🔐 Security Flow

```
┌─────────────────┐
│  Request        │
└─────────────────┘
        │
        │ 1. Check Authentication
        ▼
┌─────────────────┐     NO      ┌─────────────┐
│  Authenticated? │ ──────────→ │  Redirect   │
└─────────────────┘              │  to /login  │
        │ YES                     └─────────────┘
        │ 2. Check Admin Role
        ▼
┌─────────────────┐     NO      ┌─────────────┐
│  Is Admin?      │ ──────────→ │  Return 403 │
└─────────────────┘              └─────────────┘
        │ YES
        │ 3. Check CSRF Token
        ▼
┌─────────────────┐     NO      ┌─────────────┐
│  Valid CSRF?    │ ──────────→ │  Return 419 │
└─────────────────┘              └─────────────┘
        │ YES
        │ 4. Validate File
        ▼
┌─────────────────┐     NO      ┌─────────────┐
│  Valid MIME?    │ ──────────→ │  Return 422 │
│  Valid Size?    │              └─────────────┘
└─────────────────┘
        │ YES
        │ 5. Check Ownership (for delete)
        ▼
┌─────────────────┐     NO      ┌─────────────┐
│  User owns      │ ──────────→ │  Return 403 │
│  product?       │              └─────────────┘
└─────────────────┘
        │ YES
        │ 6. Process Request
        ▼
┌─────────────────┐
│  Success        │
└─────────────────┘
```

---

**Architecture Type:** MVC (Model-View-Controller)  
**Storage Pattern:** Local File System + Database References  
**Security:** Authentication + Authorization + CSRF + Validation  
**Frontend Pattern:** Progressive Enhancement (works with/without JS)
