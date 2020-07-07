<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chart_Model extends CI_Model {

	public function __construct(){
        parent::__construct();
        $this->load->model('User_Model');
    }
    
  
	public function getRegisteredUsersPerMonth(){
        /* Chart array */
        $ar = array();

        /* Labels of chart */
        $labels = ['Month', 'Students', 'Instructors'];
        array_push($ar, $labels);

        $this->db->select("
            count(case when myrole_id=2 then 1 end) as totalInstructors,
            count(case when myrole_id=3 then 1 end) as totalStudents ,
            DATE_FORMAT(creation_date, '%b') as month 
        ");
        $this->db->from("myuser");
        $this->db->where("id !=", 1);
        $this->db->group_by("DATE_FORMAT(creation_date, '%b')");
        $this->db->order_by("creation_date");

        $query = $this->db->get();
        if($query->num_rows() > 0){
            foreach($query->result() as $row){
                /* User information to chart */
                $userAr = [$row->month, (int)$row->totalStudents, (int)$row->totalInstructors];
                array_push($ar, $userAr);
            }
        }

        return $ar;
    }


    public function getCourses(){
        /* Chart array */
        $ar = array();

        /* Labels of chart */
        $labels = ['Status', 'Total'];
        array_push($ar, $labels);

        $students = $this->User_Model->getStudents(getUserId());
        $studentsIdAr = array();
        foreach($students as $row){
            $studentId = $row->myuser_id;
            array_push($studentsIdAr, $studentId);
        }

        $this->db->select("
            count(case when T0.status='in_progress' then 1 end) as totalInProgress,
            count(case when T0.status is null then 1 end) as totalNotInitiated,
            count(case when T0.status='finished' then 1 end) as totalFinalized
        ");
        $this->db->from("course_helper T0");
        $this->db->join("myuser T1", "T0.myuser_id = T1.id");
        $this->db->where("T1.myrole_id", 3);
        $this->db->where("T0.mycourse_id !=", 1);
        $this->db->where_in("T0.myuser_id", $studentsIdAr);    
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $result = $query->result()[0];
            $finalizedCourses = array('Finalized', (int)$result->totalFinalized);
            $inProgressCourses = array('In progress', (int)$result->totalInProgress);
            $notInitiatedCourses = array('Not initiated', (int)$result->totalNotInitiated);
            array_push($ar, $finalizedCourses);
            array_push($ar, $inProgressCourses);
            array_push($ar, $notInitiatedCourses);
        }

        return $ar;
    }

    public function getStudentCourses($studentId){
        /* Chart array */
        $ar = array();

        /* Labels of chart */
        $labels = ['Status', 'Total'];
        array_push($ar, $labels);


        $this->db->select("
            count(case when T0.status='in_progress' then 1 end) as totalInProgress,
            count(case when T0.status is null then 1 end) as totalNotInitiated,
            count(case when T0.status='finished' then 1 end) as totalFinalized
        ");
        $this->db->from("course_helper T0");
        $this->db->where("T0.myuser_id", $studentId);
        $this->db->where("T0.mycourse_id !=", 1); 
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $result = $query->result()[0];
            $finalizedCourses = array('Finalized', (int)$result->totalFinalized);
            $inProgressCourses = array('In progress', (int)$result->totalInProgress);
            $notInitiatedCourses = array('Not initiated', (int)$result->totalNotInitiated);
            array_push($ar, $finalizedCourses);
            array_push($ar, $inProgressCourses);
            array_push($ar, $notInitiatedCourses);
        }

        return $ar;
    }

}