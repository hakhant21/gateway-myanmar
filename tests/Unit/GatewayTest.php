<?php

use Hak\GatewayMyanmar\Facades\Gateway;

it('can send a request to payment gateway response back with array of webRedirectUrl, paymentToken and respCode and respDesc', function(){
    $gateway = Gateway::process([
        'amount' => 10000,
        'description' => 'test payment test',
        'invoice_no' => time(),
        'name' => 'Htet Aung Khant',
        'email' => 'htet@gmail.com'
    ]);

    expect($gateway)->toBeArray();
});

it('can request a payment gateway to inquiry and response back with array of payment inquiry data', function(){
    $gateway = Gateway::complete([
        'invoice_no' => 1684666236,
    ]);

    expect($gateway)->toBeArray();
});