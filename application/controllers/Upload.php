<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Upload extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('Upload_Model');
    }


    /* 
    =============================================
    Upload a html file
    ============================================== 
    */
	public function uploadHtml(){
        $file = $_FILES["html"];
        $upload = $this->Upload_Model->upload_html($file);
        echo json_encode($upload);
    }



}
