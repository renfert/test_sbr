<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Upload extends CI_Controller {

    function __construct(){
        parent::__construct();
    }


    /* 
    =============================================
    Upload a file
    ============================================== 
    */
	public function upload_file(){
        /* Getting params from http post request */
        foreach($_FILES as $key => $val){
            $file = $key;
        }   
        $params = array(
            'type' => $this->input->post("type"),
            'file' => $_FILES[$file]
        );
        $this->load->model('Upload_Model');
        $upload = $this->Upload_Model->upload_file($params);
        echo $upload;
    }



}
