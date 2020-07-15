<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Emails extends CI_Controller {

    function __construct(){
        parent::__construct();
    }


    public function sendPurchaseEmail(){
        $params = array(
            'domain' => $this->input->post("domain"),
            'name' => $this->input->post("name"),
            'email' => "financiero@sabiorealm.com",
            'customerEmail' => $this->input->post("customerEmail"),
            'plan' => $this->input->post("plan"),
            'step' => $this->input->post("step"),
            'type' => $this->input->post("type"),
            'country' => $this->input->post("country"),
            'template-email' => 'purchase',
            'subject' => 'new-purchase-request'
        );
        sendEmail($params);
    }


}
