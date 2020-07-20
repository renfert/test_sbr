<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verify_Model extends CI_Model {

	public function __construct(){
        parent::__construct();
        $this->load->model("Widgets_Model");
	}

    public function userIsInCourse($userId, $courseId){
        $this->db->select("myuser_id");
        $this->db->distinct();
        $this->db->from("relationship");
        $this->db->where("myuser_id", $userId);
        $this->db->where("mycourse_id", $courseId);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function stepsStatus(){
        $this->db->select("*");
        $this->db->from("first_steps");
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    public function verifyIfCourseHasAlreadyBeenEvaluated($courseId){
        $this->db->select("*");
        $this->db->from("reviews");
        $this->db->where("mycourse_id", $courseId);
        $this->db->where("myuser_id", getUserId());
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function checkPreferenceValidity($preferenceId){
        $this->db->select("*");
        $this->db->from("integrations");
        $query = $this->db->get();
        $result = $query->result();
        $preferenceIdInDataBase = $result[0]->preference_id;

        if(md5($preferenceId) == $preferenceIdInDataBase){
            return true;
        }else{
            return false;
        }
    }

    public function checkStorageAvailability(){
        $usedStorage = $this->Widgets_Model->getStorage();
        $plan = $this->getPlan();

        /*------------ 
        Basic plan 
        ------------*/
        if($plan == "basic"){
            $availableStorage = 32;
        }

        /*------------ 
        Pro plan 
        ------------*/
        if($plan == "pro"){
            $availableStorage = 64;
        }


        /*------------ 
        Growt plan 
        ------------*/
        if($plan == "growt"){
            $availableStorage = 128;
        }

        /*------------ 
        Bussiness plan 
        ------------*/
        if($plan == "bussiness"){
            $availableStorage = 512;
        }

        
        if($usedStorage >= $availableStorage){
            return false;
        }else{
            return true;
        }
    }

    public function correctAnswerExist($questionId){
        $this->db->select("T0.id");
        $this->db->distinct();
        $this->db->from("answer T0");
        $this->db->join("relationship T1", "T1.answer_id = T0.id");
        $this->db->where("T1.question_id", $questionId);
        $this->db->where("T0.id !=", 1);
        $this->db->where("T0.correct IS NOT NULL", NULL, FALSE);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    private function getPlan(){
        $this->db->select("*");
        $this->db->from("mycompany");
        $query = $this->db->get();
        $plan = $query->result()[0]->plan;
        return $plan;
    }

    public function getSubDomainName(){
        $this->db->select("*");
        $this->db->from("mycompany");
        $query = $this->db->get();
        $result = $query->result();
        return $result[0]->subdomain;
    }

    public function verifyUserCreate($role){
        $plan = $this->getPlan();

        /* Total students and instructors */
        $this->db->select("(SELECT COUNT(*) FROM myuser WHERE myrole_id = 2 ) as instructors, (SELECT COUNT(*) FROM myuser WHERE myrole_id = 3 ) as students");
        $query = $this->db->get();
        $totalInstructors = $query->result()[0]->instructors;
        $totalStudents = $query->result()[0]->students;

        /* Basic plan */ 
        if($plan == "basic"){
            if($role == "Instructor"){
                if($totalInstructors >= 1){
                    return false;
                }
            }

            if($role == "Student"){
                if($totalStudents >= 50){
                    return false;
                }
            }

        }


        /* Pro plan */ 
        if($plan == "basic"){
            if($role == "Instructor"){
                if($totalInstructors >= 3){
                    return false;
                }
            }

            if($role == "Student"){
                if($totalStudents >= 100){
                    return false;
                }
            }

        }

        /* Growt plan */ 
        if($plan == "growt"){

            if($role == "Instructor"){
                if($totalInstructors >= 5){
                    return false;
                }
            }

            if($role == "Student"){
                if($totalStudents >= 300){
                    return false;
                }
            }

        }

        /* Bussiness plan */ 
        if($plan == "bussiness"){

            if($role == "Instructor"){
                if($totalInstructors >= 100){
                    return false;
                }
            }

            if($role == "Student"){
                if($totalStudents >= 5000){
                    return false;
                }
            }

        }

        /* Trial plan */ 
        if($plan == "trial"){

            if($role == "Instructor"){
                if($totalInstructors >= 1){
                    return false;
                }
            }

            if($role == "Student"){
                if($totalStudents >= 50){
                    return false;
                }
            }

        }

        return true;
    }


}