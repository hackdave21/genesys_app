<?php

return [
    'apikey' => env('CINETPAY_APIKEY'),
    'site_id' => env('CINETPAY_SITE_ID'),
    'secret_key' => env('CINETPAY_SECRET_KEY'),
    'notify_url' => env('CINETPAY_NOTIFY_URL'),
    'return_url' => env('CINETPAY_RETURN_URL'),
    'currency' => env('CINETPAY_CURRENCY', 'XOF'),
];
