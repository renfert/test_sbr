<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->helper('url');
    }

    /* 
    =============================================
       Payment by card/
    ============================================== 
    */
	public function mercadopago(){
        $this->load->model("payments");
        $this->load->model('tolist');
        $this->load->model("toregister");
        $amount = $_REQUEST['amount'];
        $token = $_REQUEST['token'];    
        $description = $_REQUEST['description'];
        $paymentMethodId = $_REQUEST['paymentMethodId'];
        $email = $_REQUEST['email'];
        $userId = $_REQUEST['userId'];
        $courseId = $_REQUEST['idCourse'];
        $apps = $this->tolist->apps();
        $currency = $this->tolist->currency();
        $status = $this->payments->mercadopago($amount,$token,$description,$paymentMethodId,$email,$apps);

        // Register transaction
        $transactionStatus = $status['status'];
        $transactionDate = $status['date_created'];
        $transactionId = $status['id'];
        $transactionMethod = "card";
        $this->toregister->transaction($transactionId,$transactionStatus,$transactionDate,$courseId,$userId,$transactionMethod, $currency);
       
        if($status['status'] == "approved"){
            $this->toregister->enroll_product($userId,$courseId);
            $pay = "done";
        }else{
            $pay = "failed";
        }

        $dados['payment'] = $pay;
        $dados['paymentId'] = $status['id'];
        $dados['settings'] = $this->tolist->settings($userId);
        $dados['course'] = $this->tolist->singleCourse($courseId); 
        if(isset($userId)){ 
            $dados['enroll'] = $this->tolist->product_enroll($userId,$courseId);
        }   
        $dados['class'] = $this->tolist->moduleProduct($courseId);
        $dados['apps'] = $this->tolist->apps();
        $this->load->view('product_course',$dados);
    }

     /* 
    =============================================
       Payment by ticket
    ============================================== 
    */
	public function mercadopago_ticket(){
        $this->load->model("payments");
        $this->load->model('tolist');
        $this->load->model("toregister");
        $amount = $_REQUEST['amount'];
        $description = $_REQUEST['description'];
        $email = $_REQUEST['email'];
        $userId = $_REQUEST['userId'];
        $courseId = $_REQUEST['idCourse'];
        $payType = $_REQUEST['payType'];
        $apps = $this->tolist->apps();
        $currency = $this->tolist->currency();
        $status = $this->payments->mercadopago_ticket($payType,$amount,$description,$email,$apps);
        

        // Register transaction
        $transactionStatus = $status['status'];
        $transactionDate = $status['date_created'];
        $transactionId = $status['id'];
        $transactionMethod = $payType;
        $this->toregister->transaction($transactionId,$transactionStatus,$transactionDate,$courseId,$userId,$transactionMethod,$currency);
        $dados['url'] = $status['url'];
        $dados['payment'] = "pending";
        $dados['paymentId'] = $status['id'];
        $dados['settings'] = $this->tolist->settings($userId);
        $dados['course'] = $this->tolist->singleCourse($courseId);  
        if(isset($userId)){ 
            $dados['enroll'] = $this->tolist->product_enroll($userId,$courseId);
        }   
        $dados['class'] = $this->tolist->moduleProduct($courseId);
        $dados['apps'] = $this->tolist->apps();
        $this->load->view('product_course',$dados);
        // Teste
    }
    
    /* 
    =============================================
       Verify paymentss
    ============================================== 
    */
	public function verify_payments(){
        $this->load->model("payments");
        $this->load->model("tolist");
        $apps = $this->tolist->apps();
        $this->load->model('toedit');
        $this->toedit->payment_open($apps);
    }
    
}
