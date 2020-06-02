<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Integrations extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('Integrations_Model');
    }

    
	public function getIntegrations(){
        $result = $this->Integrations_Model->getIntegrations();
        echo json_encode($result);
    }

  
    public function saveAnalytics(){
        $id = $this->input->post("id");
        $result = $this->Integrations_Model->saveAnalytics($id);
        echo json_encode($result);
    }

    public function saveFbPixel(){
        $id = $this->input->post("id");
        $result = $this->Integrations_Model->saveFbPixel($id);
        echo json_encode($result);
    }

    public function saveTagManager(){
        $id = $this->input->post("id");
        $result = $this->Integrations_Model->saveTagManager($id);
        echo json_encode($result);
    }

    public function saveMpAccessToken(){
        $id = $this->input->post("id");
        $result = $this->Integrations_Model->saveMpAccessToken($id);
        echo json_encode($result);
    }

    public function saveMpPreference(){
        $preferenceId = $this->input->post("preferenceId");
        $result = $this->Integrations_Model->saveMpPreference($preferenceId);
        echo json_encode($result);
    }
}
