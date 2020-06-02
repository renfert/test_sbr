<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar_Model extends CI_Model {

	public function __construct(){
		parent::__construct();
    }
    
    
    public function get($userId){
        $lessonType_array = array(5,6);
        $this->db->select("T2.type_mylesson_id,T2.date,T2.time, T3.title");
        $this->db->distinct();
        $this->db->from("relationship T0");
        $this->db->join("lesson_status T1", "T0.mycourse_id = T1.mycourse_id");
        $this->db->join("mylesson T2", "T1.mylesson_id = T2.id");
        $this->db->join("mycourse T3", "T1.mycourse_id = T3.id");
        $this->db->where("T1.myuser_id", $userId);
        $this->db->where_in("T2.type_mylesson_id", $lessonType_array );
        $query = $this->db->get();
        if($query->num_rows() > 0){
            foreach($query->result() as $row){
                $data[] = array(
                    "highlight" => $row->type_mylesson_id == 5 ? 'orange' : 'teal',
                    "popover" =>  $row->type_mylesson_id == 5 ? array("label" => "Videoconference | Course: $row->title | $row->time "):array("label" => "Webinar | Course: $row->title | $row->time ") ,
                    "dates" => $row->date
                );
            }
            return $data;
        }
    }
}