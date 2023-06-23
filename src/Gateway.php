<?php

namespace Hak\GatewayMyanmar;

use Hak\GatewayMyanmar\Requests\GatewayRequest;

class Gateway extends GatewayRequest
{

    public function process(array $parameters = [])
    {
        $data = self::getToken([
            'amount' => self::getAmount($parameters['amount']),
            'description' => $parameters['description'],
            'invoiceNo' => self::getInvoice($parameters['invoice_no']),
            'name' => $parameters['name'],
            'email' => $parameters['email']   
        ]);

        return $data;
    }

    public function complete(array $parameters = [])
    {
         $data = self::getInquiry([
            'invoiceNo' => self::getInvoice($parameters['invoice_no'])
         ]);

         return $data;
    }
}