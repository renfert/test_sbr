<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Emails extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model("Company_Model");
    }


    public function sendPurchaseEmail(){
        $domainName = $this->Company_Model->getCompanyInformation()->subdomain; 

        $params = array(
            'domain' => $this->Company_Model->getCompanyInformation()->subdomain,
            'name' => $this->Company_Model->getCompanyInformation()->contact,
            'customerEmail' => $this->Company_Model->getCompanyInformation()->email,
            'plan' => $this->Company_Model->getCompanyInformation()->plan,
            'step' => $this->Company_Model->getCompanyInformation()->step_project,
            'type' => $this->Company_Model->getCompanyInformation()->type_project,
            'country' => $this->Company_Model->getCompanyInformation()->country,
            'email' => "financiero@sabiorealm.com",
            'template-email' => 'purchase',
            'subject' => 'new-purchase-request'
        );
        sendEmail($params);
    }


}
