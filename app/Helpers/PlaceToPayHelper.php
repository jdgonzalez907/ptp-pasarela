<?php

namespace App\Helpers;

use \Illuminate\Routing\UrlGenerator;

class PlaceToPayHelper
{
    public $login = '6dd490faf9cb87a9862245da41170ff2';
    public $secretKey = '024h1IlD';
    public $urlPoint = 'https://test.placetopay.com/redirection/';
    public $returnUrl = 'checkout/callback/';
    public $notificationUrl = 'checkout/notification/';

    function getAuthData()
    {
        $nonce = null;
        $seed = date('c');

        if (function_exists('random_bytes')) {
            $nonce = bin2hex(random_bytes(16));
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $nonce = bin2hex(openssl_random_pseudo_bytes(16));
        } else {
            $nonce = mt_rand();
        }
        $nonceBase64 = base64_encode($nonce);

        $data = [
            'auth' => [
                'login' => $this->login,
                'seed' => $seed,
                'nonce' => $nonceBase64,
                'tranKey' => base64_encode(sha1($nonce . $seed . $this->secretKey, true))
            ]
        ];

        return $data;
    }

    function sendPayment($checkoutInfo)
    {
        $client = new \GuzzleHttp\Client([
            'headers' => [
                'Content-Type' => 'application/json']
        ]);

        $data = $this->getAuthData();

        $data['buyer'] = [
            "document" => $checkoutInfo["document"],
            "documentType" => $checkoutInfo["documentType"],
            "name" => $checkoutInfo["first_name"],
            "surname" => $checkoutInfo["last_name"],
            "email" => $checkoutInfo["email"],
            "mobile" => $checkoutInfo['phone'],
            "address" => [
               "street" => $checkoutInfo["address"],
               "city" => $checkoutInfo["city"],
               "country" => "CO"
            ],
        ];

        $data['expiration'] = $checkoutInfo['expiration'];

        $data['payment'] = [
            'reference' => $checkoutInfo['id'],
            'description' => $checkoutInfo['description'],
            'amount' => [
                'total' => $checkoutInfo['amount'],
                "currency" => "COP",
            ]
        ];

        $data['returnUrl'] = url()->to($this->returnUrl . $checkoutInfo['id']);
        $data['ipAddress'] = $checkoutInfo['ipAddress'];
        $data['userAgent'] = $checkoutInfo['userAgent'];
        
        $response = $client->post( 
            $this->urlPoint . 'api/session/',
            [
                'json' => $data
            ]
        );

        $json = null;
        
        if ($response->getStatusCode() == 200) {
            $json = json_decode($response->getBody());
        }

        return $json;
    }

    function obtainPayment($checkoutInfo) {
        $client = new \GuzzleHttp\Client([
            'headers' => [
                'Content-Type' => 'application/json']
        ]);
        
        $data = $this->getAuthData();

        $response = $client->post( 
            $this->urlPoint . 'api/session/' . $checkoutInfo['requestId'],
            [
                'json' => $data
            ]
        );

        $json = null;
        
        if ($response->getStatusCode() == 200) {
            $json = json_decode($response->getBody());
        }

        return $json;
    }
}