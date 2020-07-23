<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Settings extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('Settings_Model');
    }

    /* 
    =============================================
    Returns: array with only one object
    ============================================== 
    */
	public function getSettingsInformation(){
        $result = $this->Settings_Model->getSettingsInformation();
        echo json_encode($result);
    }

    /* 
    =============================================
    Edit settings
    ============================================== 
    */
	public function edit(){
        $params = array(
            'name' => applySecurityFunctions($this->input->post("name")),
            'email' => applySecurityFunctions($this->input->post("email")),
            'description' => applySecurityFunctions($this->input->post("description")),
            'phone' => applySecurityFunctions($this->input->post("phone")),
            'lang' => $this->input->post("language"),
            'marketplace' => $this->input->post("marketplace"),
            'logo' => $this->input->post("logo"),
            'favicon' => $this->input->post("favicon"),
            'zone' => $this->input->post("timezone")
        );
        $this->load->model('Settings_Model');
        $settings = $this->Settings_Model->edit($params);
        echo json_encode($settings);
        
    }

    /* 
    =============================================
    Edit primary color
    ============================================== 
    */
    public function editPrimaryColor(){
        $params = array(
            "color" => $this->input->post("color")
        );
        $result = $this->Settings_Model->editPrimaryColor($params);
        echo json_encode($result);
    }
}
