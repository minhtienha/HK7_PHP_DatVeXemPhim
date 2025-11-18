<?php

// config/momo.php
// Cấu hình Momo Payment Gateway

return [
    // Test environment
    'test' => [
        'endpoint' => env('MOMO_TEST_ENDPOINT', 'https://test-payment.momo.vn/v2/gateway/api/create'),
        'partner_code' => env('MOMO_PARTNER_CODE', 'MOMOBKUN20180529'),
        'access_key' => env('MOMO_ACCESS_KEY', 'klm05TvNBzhg7h7j'),
        'secret_key' => env('MOMO_SECRET_KEY', 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa'),
    ],

    // Production environment (bạn cần cập nhật này với credentials thực)
    'production' => [
        'endpoint' => env('MOMO_PRODUCTION_ENDPOINT', 'https://payment.momo.vn/v2/gateway/api/create'),
        'partner_code' => env('MOMO_PRODUCTION_PARTNER_CODE', ''),
        'access_key' => env('MOMO_PRODUCTION_ACCESS_KEY', ''),
        'secret_key' => env('MOMO_PRODUCTION_SECRET_KEY', ''),
    ],

    // Cài đặt chung
    'store_name' => env('MOMO_STORE_NAME', 'Rạp chiếu 4T'),
    'store_id' => env('MOMO_STORE_ID', '4T_Cinema'),
    'environment' => env('MOMO_ENV', 'test'), // test hoặc production
];
