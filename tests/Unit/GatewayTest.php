<?php

use Hak\GatewayMyanmar\Facades\Gateway;

beforeEach(function(){
    $this->paraemters = [
        'amount' => 10000,
        'description' => 'test payment test',
        'invoice_no' => time(),
        'name' => 'Htet Aung Khant',
        'email' => 'htet@gmail.com'
    ];

    $this->inquiryParams = [
        'invoice_no' => 1684666236
    ];
});

it('can send a request to payment gateway response back with array of webRedirectUrl, paymentToken and respCode and respDesc', function(){
    $gateway = Mockery::mock(Gateway::process($this->paraemters));

    $mockGateway = $gateway->shouldReceive($gateway)->andReturn(['webPaymentUrl', 'paymentToken', 'respCode', 'respDesc']);

    expect($mockGateway)->toBeObject();
});

it('can request a payment gateway to inquiry and response back with array of payment inquiry data', function(){
    $gateway = Mockery::mock(Gateway::complete($this->inquiryParams));

    $mockGateway = $gateway->shouldReceive($gateway)->andReturn(['cardNo', 'respCode', 'respDesc']);

    expect($mockGateway)->toBeObject();
});