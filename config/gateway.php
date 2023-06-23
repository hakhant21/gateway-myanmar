<?php

return [
    'merchant_id' => 'JT02',
    'secret_key' => '72B8F060B3B923E580411200068A764610F61034AE729AB9EF20CAFF93AFA1B9',
    'currency_code' => 'MMK',
    'payment_channel' => ['CC', 'MPU', 'QR', 'DPAY', 'IMBANK'],
    'frontend_result_url' => 'http://project.test/checkout',
    'backend_result_url' => 'http://project.test/checkout',
    'sandbox_mode' => true,
    'gateway_url' => [
        'token' => 'paymentToken',
        'inquiry' => 'paymentInquiry'
    ],
    'locale' => "mm"
];