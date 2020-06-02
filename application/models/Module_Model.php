<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Module_Model extends CI_Model {

	public function __construct(){
		parent::__construct();
    }
    
  
	public function create($dataReceiveFromPost){
        
        $courseId = $dataReceiveFromPost["courseId"];
        $position = $this->getPositionForThisModule($courseId);

        $data = array(
            'title' => $dataReceiveFromPost["title"],
            'release_date' => $dataReceiveFromPost["date"],
            'required_to_next' => $dataReceiveFromPost["required"],
            'position' => $position
        );

        $this->db->insert("mymodule", $data);
        $moduleId = $this->db->insert_id();

        $data = array(
            'myuser_id' => 1,
            'mycourse_id' => $dataReceiveFromPost["courseId"],
            'mymodule_id' => $moduleId,
            'mylesson_id' => 1,
            'mygroup_id' => 1,
            'question_id' => 1,
            'answer_id' => 1,
            'program_id' => 1
        );
        $this->db->insert("relationship", $data);
        return $moduleId;
        
    }

    private function getPositionForThisModule($courseId){
        $this->db->select("T0.mycourse_id as courseId,count(T0.mymodule_id) as totalModules");
        $this->db->from("relationship T0");
        $this->db->where("T0.mycourse_id", $courseId);
        $this->db->where("T0.mymodule_id !=", 1);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $result = $query->result();
            $numberOfModules = $result[0]->totalModules;
        }

        return $numberOfModules + 1;
    }

 
	public function reorder($modules){
        $x = 0;
        foreach($modules as $key=>$val){
            $moduleId = $key;
            $position = $val;

            $data = array(
                'position' => $position
            );

            $this->db->where("id", $moduleId);
            $this->db->update("mymodule", $data);
        }
    }

  
	public function edit($dataReceiveFromPost){
        $title = $dataReceiveFromPost["title"];
        $id = $dataReceiveFromPost["id"];
        $required = $dataReceiveFromPost["required"];
        $date = $dataReceiveFromPost["date"];
    
        $data = array(
            'title' => $title,
            'required_to_next' => $required,
            'release_date' => $date
        );
        $this->db->where("id", $id);
        if($this->db->update("mymodule", $data)){
            return true;
        }else{
            return false;
        }
        
    }

    
    
	public function delete($moduleId){
        /* Delete from relationship */
        $this->db->where('mymodule_id',$moduleId);
        $this->db->delete("relationship");
        
        /* Delete from mymodule */
        $this->db->where('id',$moduleId);
        $this->db->delete("mymodule");
        return true;
    }
    
    
    public function listing($courseId){

        $newArray = array();

        $this->db->select("DISTINCT(T0.mymodule_id),(select count(DISTINCT mylesson_id) from relationship where mymodule_id = T1.id AND mylesson_id != 1 ) as totalLessons,T1.id, T1.title, T1.position,T1.required_to_next, T1.release_date");
        $this->db->from("relationship T0");
        $this->db->join('mymodule T1', 'T0.mymodule_id = T1.id');
        $this->db->where("T0.mycourse_id", $courseId);
        $this->db->where("T1.id !=", 1);
        $this->db->order_by('position', 'ASC');
      
        $query = $this->db->get();
        if($query->num_rows() > 0){
            foreach($query->result() as $row){

                $disable = $this->checkModuleAvailability($row->id, $courseId);

                $ar = array(
                    'id' =>  $row->id,
                    'totalLessons' =>  $row->totalLessons,
                    'title' => $row->title,
                    'position' => $row->position,
                    'required_to_next' => $row->required_to_next,
                    'release_date' => $row->release_date,
                    'disable' => $disable < 1 ? false : true
                );
                
                array_push($newArray, $ar);

            }
            return $newArray;
        }
    }

    public function checkModuleAvailability($moduleId,$courseId){
        $userId = getUserId();
        $sql = "
        SELECT DISTINCT T3.mylesson_id,T3.status 
        FROM relationship T0 
        INNER JOIN mymodule T1 ON T0.mymodule_id = T1.id 
        INNER JOIN mylesson T2 ON T0.mylesson_id = T2.id 
        INNER JOIN lesson_status T3 ON T2.id = T3.mylesson_id 
        WHERE T0.mycourse_id = $courseId AND T2.id != 1 AND T3.myuser_id = $userId AND T3.status IS NULL AND T1.id = (SELECT DISTINCT max(mymodule_id) FROM relationship T0 INNER join mymodule T1 ON T0.mymodule_id = T1.id WHERE mycourse_id = $courseId AND mymodule_id != 1 AND mymodule_id < $moduleId  AND T1.required_to_next IS NOT NULL)";
        if($query = $this->db->query($sql)){
            return $query->num_rows();
        }else{
            return 0;
        }
    }
}