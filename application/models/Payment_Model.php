<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_Model extends CI_Model {

    function __construct(){
        parent::__construct();  
        $this->load->database();
    }

    
    public function savePurchaseRequisition($courseId,$paymentId,$paymentStatus){
        $data = array(
            "payment_id" => $paymentId,
            "payment_status" => $paymentStatus,
            "myuser_id" => getUserId(),
            "mycourse_id" => $courseId
        );

        $this->db->insert("payments", $data);
    }

    
   /* 
   =============================================
   Mercadopago card
   ============================================== 
   */
	public function mercadopago($amount,$token,$description,$paymentMethodId,$email,$apps){
        $accessToken = base64_decode($apps['accessToken']);
        require_once 'vendor/autoload.php';
        MercadoPago\SDK::setAccessToken("$accessToken");
        $payment = new MercadoPago\Payment();
        $payment->transaction_amount = round((float)$amount,2);
        $payment->token = $token;
        $payment->description = $description;
        $payment->installments = 1;
        $payment->payment_method_id = "$paymentMethodId";
        $payment->payer = array("email" => $email);       
        $payment->save();
        $pay['status'] = $payment->status; 
        $pay['id'] = $payment->id;
        $pay['date_created'] = $payment->date_created;
        return $pay;   
    }


    /* 
   =============================================
   Mercadopago ticket
   ============================================== 
   */
	public function mercadopago_ticket($payType,$amount,$description,$email,$apps){
        $accessToken = base64_decode($apps['accessToken']);
        require_once 'vendor/autoload.php';
        MercadoPago\SDK::setAccessToken("$accessToken");
        
        $payment = new MercadoPago\Payment();
        $payment->transaction_amount = round((float)$amount,2);
        $payment->description = $description;
        $payment->payment_method_id = $payType;
        $payment->payer = array("email" => $email);     
        if($payment->save()){
            $pay['status'] = $payment->status; 
            $pay['id'] = $payment->id;
            $pay['date_created'] = $payment->date_created;
            $pay['url'] =  $payment->transaction_details->external_resource_url;
            return $pay;     
        }
        
    }
    
}
