<?php

namespace Hak\GatewayMyanmar\Requests;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

abstract class GatewayRequest 
{
    const SANDBOX_URL = 'https://sandbox-pgw.2c2p.com/payment/4.1/';
    const LIVE_URL = 'https://pgw.2c2p.com/payment/4.1/';
    
    public static function getToken(array $payload = [])
    {
        if($payload['name'] || $payload['email']) {
            $payload['uiParams'] = [
                'userInfo' => [
                    'name' => $payload['name'],
                    'email' => $payload['email']
                ]
            ];
        }

        $parameters = array_merge($payload,[
            'merchantID' => config('gateway.merchant_id'),
            'currencyCode' => config('gateway.currency_code'),
            'paymentChannel' => config('gateway.payment_channel'),
            'returnUrl' => config('gateway.returnUrl'),
            'notifyUrl' => config('gateway.notifyUrl'),
         ]);

         $token = self::encrypted($parameters);

         $payload = json_encode(['payload' => $token]);

         return get_object_vars(self::send(config('gateway.gateway_url.token'), $payload));
    }

    public static function getInquiry(array $payload = [])
    {
        $parameters = array_merge($payload, [
            'merchantID' => config('gateway.merchant_id'),
            'locale' => config('gateway.locale')
        ]);

        $token = self::encrypted($parameters);

        $payload = json_encode(['payload' => $token]);

        return get_object_vars(self::send(config('gateway.gateway_url.inquiry'), $payload));
    }

    public static function encrypted(array $parameters) 
    {
         return JWT::encode($parameters, config('gateway.secret_key'), 'HS256');
    }

    public static function decrypted(string $payload)
    {
        return JWT::decode($payload, new Key(config('gateway.secret_key'), 'HS256'));
    }

    public static function getAmount($amount)
    {
        return str_pad($amount, 12, '0', STR_PAD_LEFT);
    }

    public static function getInvoice($invoice)
    {
        return str_pad($invoice, 12, '0', STR_PAD_LEFT);
    }

    public static function getBaseUrl()
    {
        if(config('gateway.sandbox_mode') == true) {
            return self::SANDBOX_URL;
        } else {
            return self::LIVE_URL;
        }
    }

    public static function send(string $path, $payload)
    {
         $client = new Client([
            'base_uri' => self::getBaseUrl(),
            'headers' => [
                'Content-Type' => 'application/json'
            ]
         ]);
         try{
            $response = $client->request('POST', $path, [
                'body' => $payload
            ])->getBody()->getContents();

            $data = json_decode($response, true);

            return self::decrypted($data['payload']);
         }catch(GuzzleException $e){
            return $e->getMessage();
         }
    }
}