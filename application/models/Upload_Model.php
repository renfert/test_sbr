<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Upload_Model extends CI_Model {

	public function __construct(){
		parent::__construct();
    }

    public function upload_html($file){
        $this->createTempFolder();
        $this->uploadFileToTmpFolder($file);
        $this->extractZip();
        $this->verifyIfExistInvalidExtensions();
    }



    private function createTempFolder(){
        $folder = "tmp";

        if(file_exists($folder)){
            unlink($folder);
        }
        mkdir ($folder);
    }


    /* 
    =============================================
    This function upload the zip file to tmp folder
    ============================================== 
    */
    private function uploadFileToTmpFolder($file){
        $folderPath ="tmp/files.zip";
        move_uploaded_file($file["tmp_name"],$folderPath);
    }


    /* 
    =============================================
    This function will extract all files from zip
    ============================================== 
    */
    private function extractZip(){
        $zip = new ZipArchive;  
        $resultOpen = $zip->open("tmp/files.zip");
        if ($resultOpen === TRUE) {
            $zip->extractTo("tmp");
            $zip->close();
            unlink("tmp/files.zip");
        }
    }

    private function verifyIfExistInvalidExtensions(){
        $files = array_diff(scandir("tmp"), array('.', '..'));
        foreach($files as $file){
            $file_parts = pathinfo($file);
            if(!isset($file_parts['extension'])){
               
            }else{
                $fileExtension = $file_parts['extension'];
                if($fileExtension != "html" AND $fileExtension != "js" AND $fileExtension != "css" AND $fileExtension != "xml" AND $fileExtension != "xsd" AND $fileExtension != "swf"){
                    unlink("tmp/".$file);
                }
            }
        }
    }


}