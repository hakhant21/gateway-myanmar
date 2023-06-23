# Myanmar Payment Integration Package 
[![Testing](https://github.com/hakhant21/gateway-myanmar/actions/workflows/main.yml/badge.svg?branch=main&event=push)](https://github.com/hakhant21/gateway-myanmar/actions/workflows/main.yml)

## Installation
```bash

composer require hak/gateway-myanmar

```

### Usage 

```php

use Illuminate\Http\Request;
use Hak\GatewayMyanmar\Facades\Gateway;

public function store(Request $request)
{
    // Request for paymentToken and Redirect Url
    $token = Gateway::process([
        'amount' => $request->amount,
        'invoice_no' => time(), 
        'description' => $request->description,
        'name' => $name,
        'email' => $email
    ]);

    return $token; // that will return array of webPaymentUrl, paymentToken, respCode, respDesc 

    // Request for paymentInquiry
    $inquiry = Gateway::complete([
        'invoice_no' => 1684666236,
    ]);

    return $inquiry; // that will return as an array of payment inquiry data
}
```

### Publish config file

```bash

php artisan vendor:publish --provider="Hak\GatewayMyanmar\GatewayServiceProvider" --tag="gateway"

```

### ENVIROMENT VARIABLES 

#### You can get config variables from developer.2c2p.com 
  * MERCHANT_ID // JT02 
  * SECRET_KEY // SHA256 key
  * BASE_URL  // https://sandbox-pgw.2c2p.com/payment/4.1/ for ( Sandbox )
  * RESULT_URL_1 // https://example.com/fronend-result-url
  * RESULT_URL_2 // https://example.com/backend-result-url
