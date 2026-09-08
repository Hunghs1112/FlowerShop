<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Zalo Official Account Configuration
    |--------------------------------------------------------------------------
    |
    | Configure your Zalo OA credentials here.
    | Get these from: https://developers.zalo.me/
    |
    */

    'oa_id' => env('ZALO_OA_ID', ''),
    'oa_secret' => env('ZALO_OA_SECRET', ''),
    'access_token' => env('ZALO_ACCESS_TOKEN', ''),
    'refresh_token' => env('ZALO_REFRESH_TOKEN', ''),
    
    /*
    |--------------------------------------------------------------------------
    | Admin User ID
    |--------------------------------------------------------------------------
    |
    | Zalo User ID của admin để nhận thông báo đơn hàng mới
    |
    */
    'admin_user_id' => env('ZALO_ADMIN_USER_ID', ''),

    /*
    |--------------------------------------------------------------------------
    | API Endpoints
    |--------------------------------------------------------------------------
    */
    'api_url' => 'https://openapi.zalo.me/v2.0/oa',
    'auth_url' => 'https://oauth.zaloapp.com/v4/oa',
];
