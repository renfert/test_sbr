<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Module extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Module_Model');
    }

   
	public function create(){
        $dataReceiveFromPost = array(
            'title' => $this->input->post("title"),
            'date' => $this->input->post("date"),
            'required' => $this->input->post("required"),
            'courseId' => $this->input->post("courseId"),
        );
        $resultModuleCreate = $this->Module_Model->create($dataReceiveFromPost);
        echo json_encode($resultModuleCreate);
    }

   
	public function reorder(){
        $this->Module_Model->reorder($this->input->post("module"));
    }

    
    public function edit(){
        $this->input->post("date") == '' ? $releaseDate = null : $releaseDate =  $this->input->post("date");

        $dataReceiveFromPost = array(
            'id' => $this->input->post("id"),
            'title' => $this->input->post("title"),
            'required' => $this->input->post("required"),
            'date' => $releaseDate,
        );
        $resultModuleEdit = $this->Module_Model->edit($dataReceiveFromPost);
        echo json_encode($resultModuleEdit);
    }

  
    public function listing(){
        $courseId = $this->input->post("courseId");
        $moduleList = $this->Module_Model->listing($courseId);
        echo json_encode($moduleList);
    }

    
    
    public function delete(){
        $moduleId = $this->input->post("id");
        $resultModuleDelete = $this->Module_Model->delete($moduleId);
        echo json_encode($resultModuleDelete);
    }

    public function checkModuleAvailability(){
        $moduleId = $this->input->post("moduleId");
        $courseId = $this->input->post("courseId");
        $result = $this->Module_Model->checkModuleAvailability($moduleId,$courseId);
        echo json_encode($result);
    }
}
