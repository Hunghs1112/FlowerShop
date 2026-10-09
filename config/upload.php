<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Whitelisted MIME types
    |--------------------------------------------------------------------------
    |
    | Only these MIME types are accepted for image uploads across the
    | application. Anything outside this list is rejected with a 422.
    |
    | The keys are the actual MIME strings the browser/server reports. The
    | values are used for human-friendly error messages.
    |
    */
    'allowed_mimes' => [
        'image/jpeg' => 'JPEG',
        'image/png'  => 'PNG',
        'image/gif'  => 'GIF',
        'image/webp' => 'WebP',
    ],

    /*
    |--------------------------------------------------------------------------
    | Allowed extensions
    |--------------------------------------------------------------------------
    |
    | Extensions derived from the *server side* (UploadedFile::extension())
    | that we treat as safe. These must stay in sync with the MIME whitelist
    | above. We never use the value supplied by the client.
    |
    */
    'allowed_extensions' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],

    /*
    |--------------------------------------------------------------------------
    | Per-feature size & count limits (KB)
    |--------------------------------------------------------------------------
    |
    | Limits are expressed in kilobytes for readability. The service converts
    | them to bytes before applying Laravel's `max` validator rule.
    |
    */
    'limits' => [
        'category_image' => [
            'max_size'  => 2048,  // 2 MB
            'max_count' => 1,
        ],
        'post_thumbnail' => [
            'max_size'  => 2048,
            'max_count' => 1,
        ],
        'product_images' => [
            'max_size'  => 2048,
            'max_count' => 10,   // hard upper bound per request
        ],
        'product_videos' => [
            'max_size'  => 51200,  // 50 MB
            'max_count' => 5,
        ],
        'site_logo' => [
            'max_size'  => 2048,
            'max_count' => 1,
        ],
        'banner' => [
            'max_size'  => 4096,  // 4 MB - banners are larger
            'max_count' => 1,
        ],
        'variant_image' => [
            'max_size'  => 2048,
            'max_count' => 10,
        ],
        'page_header' => [
            'max_size'  => 4096,
            'max_count' => 1,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Storage disks / folders
    |--------------------------------------------------------------------------
    |
    | The default disk + folder layout used by ImageStorageService when no
    | explicit path is supplied. Anything in `public/images/banners` is read
    | directly (see BannerService) so banners live there.
    |
    */
    'disks' => [
        'default' => 'public',
        'folders' => [
            'category' => 'categories',
            'post'     => 'posts',
            'product'  => 'products',
            'video'    => 'products/videos',
            'logo'     => 'settings',
            'banner'      => 'images/banners',  // special: not on `public` disk
            'page_header' => 'images/pages',     // special: not on `public` disk
            'variant'     => 'variants',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Banner disk name
    |--------------------------------------------------------------------------
    |
    | BannerService writes banners into the local filesystem (not the `public`
    * Storage disk) so they live directly under public/images/banners/ and can
    * be served by web servers without symlink tweaks. Keep this name in
    * sync with config/filesystems.php.
    */
    'banner_disk' => null, // null = local filesystem (public_path)
];