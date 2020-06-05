<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Widgets_Model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

    public function getTotalNumberOfUsers(){
        $this->db->select("COUNT(*) as total");
        $this->db->from("myuser");
        $this->db->where("id !=", 1);
        $query = $this->db->get();
        return $query->result()[0];
    }

  
    public function getTotalNumberOfCourses(){
        $this->db->select("COUNT(*) as total");
        $this->db->from("mycourse");
        $this->db->where("id !=", 1);
        $query = $this->db->get();
        return $query->result()[0];
    }
   
    public function getStorage(){
        
        // All media content size
        $dir = './assets/uploads/content';
        $sizeUploads = 0;
        $file_data = scandir($dir);
        foreach($file_data as $file){
            if($file === '.' OR $file === '..'){
                continue;
            }else{
                $path = $dir . '/' . $file;
                $sizeUploads = $sizeUploads + filesize($path);
            }
        }
 
        // Course images size
        $dir = './assets/uploads/course';
        $sizeCourse = 0;
        $file_data = scandir($dir);
        foreach($file_data as $file){
            if($file === '.' OR $file === '..'){
                continue;
            }else{
                $path = $dir . '/' . $file;
                $sizeCourse = $sizeCourse + filesize($path);
            }
        }
 
        // Courses preview video size
        $dir = './assets/uploads/preview';
        $sizePreview = 0;
        $file_data = scandir($dir);
        foreach($file_data as $file){
            if($file === '.' OR $file === '..'){
                continue;
            }else{
                $path = $dir . '/' . $file;
                $sizePreview = $sizePreview + filesize($path);
            }
        }
 
        // Program images size
        $dir = './assets/uploads/program';
        $sizeProgram = 0;
        $file_data = scandir($dir);
        foreach($file_data as $file){
            if($file === '.' OR $file === '..'){
                continue;
            }else{
                $path = $dir . '/' . $file;
                $sizeProgram = $sizeProgram + filesize($path);
            }
        }
 
        // Questions size
        $dir = './assets/uploads/question';
        $sizeQuestion = 0;
        $file_data = scandir($dir);
        foreach($file_data as $file){
            if($file === '.' OR $file === '..'){
                continue;
            }else{
                $path = $dir . '/' . $file;
                $sizeQuestion = $sizeQuestion + filesize($path);
            }
        }
 
        $totalSize = $sizeCourse + $sizePreview + $sizeUploads + $sizeProgram + $sizeQuestion;       
        return number_format($totalSize / 1073741824, 1 );
    }

}