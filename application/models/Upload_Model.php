<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_Model extends CI_Model {

	public function __construct(){
		parent::__construct();
    }

   
    /* 
    =============================================
    This function generates a random string
    ============================================== 
    */
    public function generateRandomString(){
        $lenght = mt_rand(15,20);
        $all_str = "abcdefghijlkmnopqrstuvxyzwABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        $randomName = "";
        for ($i = 0;$i <= $lenght;$i++){
            $randomName .= $all_str[mt_rand(0,61)];
        }
        return $randomName;
    }


    /* 
    =============================================
    This is the main upload function. Here we receive the request and redirect to a more specific one depending on the type of upload.
    ============================================== 
    */
	public function upload_file($params){
        $type = $params["type"];
        $file = $params["file"];
    
        switch ($type) {
            case 'image-course':
                $dir = 'assets/uploads/course/';
                $name = $this->uploadDefault($file, $dir);
                return $name;
                break;
            case 'video-preview':
                $dir = 'assets/uploads/preview/';
                $name = $this->uploadVideo($file,$dir);
                return $name;
                break;
            case 'settings':
                $dir = 'assets/uploads/settings/';
                $name = $this->uploadDefault($file,$dir);
                return $name;
                break;
            case 'lesson-video': 
                $dir = 'assets/uploads/content/';
                $name = $this->uploadVideo($file,$dir);
                return $name;
                break;
            case 'lesson-audio': 
                $dir = 'assets/uploads/content/';
                $name = $this->uploadAudio($file,$dir);
                return $name;
                break;
            case 'lesson-pdf':
                $dir = 'assets/uploads/content/';
                $name = $this->uploadDefault($file,$dir);
                return $name;
                break;
            case 'lesson-downloadable':
                $dir = 'assets/uploads/content/';
                $name = $this->uploadDefault($file,$dir);
                return $name;
                break;
            case 'lesson-html':
                $dir = 'assets/uploads/html/';
                $name = $this->uploadHtml($file,$dir);
                return $name;
                break;
            case 'question-image':
                $dir = 'assets/uploads/question/';
                $name = $this->uploadDefault($file,$dir);
                return $name;
                break;
            case 'logo-site':
                $dir = 'assets/uploads/builder/header/';
                $name = $this->uploadDefault($file,$dir);
                return $name;
                break;
            case 'banner':
                $dir = 'assets/uploads/builder/body/';
                $name = $this->uploadDefault($file,$dir);
                return $name;
                break;
            case 'testimonial-avatar':
                $dir = 'assets/uploads/testimonial/';
                $name = $this->uploadDefault($file,$dir);
                return $name;
                break;
            case 'media':
                $dir = 'assets/uploads/builder/body/';
                $name = $this->uploadDefault($file,$dir);
                return $name;
                break;
            case 'program':
                $dir = 'assets/uploads/program/';
                $name = $this->uploadDefault($file,$dir);
                return $name;
                break;
            case 'answer-exam':
                $dir = 'assets/uploads/answers/';
                $name = $this->uploadDefault($file,$dir);
                return $name;
                break;
            case 'profile-avatar':
                $dir = 'assets/uploads/avatar/';
                $name = $this->uploadDefault($file,$dir);
                return $name;
                break;
        }
        
    }

    /* 
    =============================================
    This function uploads videos exclusively
    ============================================== 
    */
    private function uploadVideo($file,$dir){
        $name = $file['name'];
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        $randomName = $this->generateRandomString();
        $newFileName = date('YmdHis').$randomName.".".$ext;
        $uploadfile = $dir . basename($newFileName);
        move_uploaded_file($file['tmp_name'], $uploadfile);
        return $newFileName;
    }

    /* 
    =============================================
    This function uploads audios exclusively
    ============================================== 
    */
    private function uploadAudio($file,$dir){
        $name = $file['name'];
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        $randomName = $this->generateRandomString();
        $newFileName = date('YmdHis').$randomName.".".$ext;
        $uploadfile = $dir . basename($newFileName);
        move_uploaded_file($file['tmp_name'], $uploadfile);
        return $newFileName;
    }

    /* 
    =============================================
    This function uploads html exclusively
    ============================================== 
    */
    private function uploadHtml($file,$dir){
        $folderPath =  $this->createNewRandomNameDirectory($dir);
        $name = $file['name'];
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        $randomName =  $this->generateRandomString();
        $newFileName = date('YmdHis').$randomName.".".$ext;
        $uploadfile = $folderPath. basename($newFileName);
        move_uploaded_file($file['tmp_name'], $uploadfile);    
        
        $this->extractZip($folderPath,$newFileName);
        $this->verifyIfExistInvalidExtensions($folderPath);
        return $folderPath;
    }

    private function extractZip($folderPath,$newFileName){
        $zip = new ZipArchive;
        $resultOpen = $zip->open($folderPath.$newFileName);
        if ($resultOpen === TRUE) {
            $zip->extractTo($folderPath);
            $zip->close();
        }
    }

    private function verifyIfExistInvalidExtensions($folderPath){
        $files = array_diff(scandir($folderPath), array('.', '..'));
        foreach($files as $file){
            $file_parts = pathinfo($file);
            if(!isset($file_parts['extension'])){
               
            }else{
                $fileExtension = $file_parts['extension'];
                if($fileExtension != "html" AND $fileExtension != "js" AND $fileExtension != "css" AND $fileExtension != "xml" AND $fileExtension != "xsd" AND $fileExtension != "swf"){
                    unlink($folderPath.$file);
                }
            }
        }
    }

    private function createNewRandomNameDirectory($dir){
        $randomName = $this->generateRandomString();
        mkdir($dir.$randomName , 0755, true);
        return $dir.$randomName."/";
    }

    /* 
    =============================================
    This function uploads files such as: .PDF, .XLSX, .DOCX, .PNG, .JPG, .ETC;
    ============================================== 
    */
    private function uploadDefault($file,$dir){
        $name = $file['name'];
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        $randomName = $this->generateRandomString();
        $newFileName = date('YmdHis').$randomName.".".$ext;
        $uploadfile = $dir . basename($newFileName);
        move_uploaded_file($file['tmp_name'], $uploadfile);
        return $newFileName;
    }
}