<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require "vendor/autoload.php";
class Payment
{
    public function __construct()
    {
    }

    public function makeExternalPaymentMP($data){
        $clientId = $data['keys']['clientId'];
        $secretId = $data['keys']['secretId'];
        $newClientId = base64_decode($clientId);
        $newSecret = base64_decode($secretId);
    

        MercadoPago\SDK::setClientId($newClientId);
        MercadoPago\SDK::setClientSecret($newSecret);

        $preference = new MercadoPago\Preference();

        $sandbox = true;
        $courseId = $data['course']->id;
        $courseEncode = urlencode(base64_encode($courseId));
        //Preferências
        //Item
        $item = new MercadoPago\Item();
        $item->id = $data['course']->id;
        $item->title = $data['course']->title;
        $item->quantity = 1;
        $item->currency_id = $data['currency'];
        $item->unit_price = $data['course']->price;

        //Comprador
        $payer = new MercadoPago\Payer();
        // $payer->email = "test_user_36111379@testuser.com";

        //Método de Pagamento
        $preference->payment_methods = array(
            "excluded_payment_types" => array(
                array("id" => "ticket")
            ),
            "installments" => 1
        );

        $preference->items = array($item);
        // $preference->payer = $payer;

        $preference->back_urls = array(            
            "success" => site_url("/pages/product_course?id=".$courseEncode)
        );

        $preference->save();

        return $sandbox ? $preference->sandbox_init_point : $preference->init_point;
    }

    public function createUser(){
        MercadoPago\SDK::setAccessToken("TEST-6879657297193510-041322-346e07861569b3c3ff17a404415281e9-426624866");

        $body = array(
            "json_data" => array(
                "site_id" => "MLB"
            )
        );

        $result = MercadoPago\SDK::post('/users/test_user', $body);

        return $result;
    }
}