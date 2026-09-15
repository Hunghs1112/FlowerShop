<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Resend, Postmark, AWS, and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Zalo OA Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Zalo Official Account API integration.
    | Used for sending order notifications to admin and customers.
    |
    | Setup Instructions:
    | 1. Create a Zalo Official Account (OA) at https://oa.zalo.me
    | 2. Get your OA ID from the OA management page
    | 3. Get an access token from Zalo Developer Portal
    | 4. Set admin phone number to receive order notifications
    |
    */

    'zalo' => [
        'oa_id' => env('ZALO_OA_ID', ''),
        'access_token' => env('ZALO_ACCESS_TOKEN', ''),
        'admin_phone' => env('ZALO_ADMIN_PHONE', ''),
        'admin_zalo_id' => env('ZALO_ADMIN_USER_ID', ''),
        'hotline' => env('ZALO_HOTLINE', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | Email Notification Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for order notification emails.
    |
    | Gmail SMTP Setup:
    | 1. Enable 2-Factor Authentication on your Google account
    | 2. Go to https://myaccount.google.com/apppasswords
    | 3. Generate an App Password for "Mail"
    | 4. Use the App Password (not your regular password) in MAIL_PASSWORD
    |
    | Note: Gmail has a limit of 500 emails per day
    |
    */

    'mail' => [
        'admin_email' => env('MAIL_ADMIN_EMAIL', ''),
        'enabled' => env('MAIL_NOTIFICATIONS_ENABLED', true),
    ],

];
