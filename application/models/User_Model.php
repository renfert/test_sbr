<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->helper("email");
		$this->load->model('Course_Model');
		$this->load->model('Program_Model');
	}

	

	public function create($dataReceiveFromPost){
		$name = $dataReceiveFromPost["name"];
		$email = $dataReceiveFromPost["email"];
		$password = $dataReceiveFromPost["password"];
		$dataReceiveFromPost["role"] == 'Instructor'  ? $role = 2 : $role = 3;
		/* 
		=============================================
		We need verify if user already exist and if the role ID == 1. User registration with role = 1 is not allowed!
		============================================== 
		*/
        $this->db->where("email", $email);
        $query = $this->db->get("myuser");
        if($query->num_rows() > 0 OR $role == 1){
            return false;
        }else{
			$params = array(
				'name' => $name,
				'email' => $email,
				'password' => md5($password),
				'myrole_id' => $role,
				'status' => 'off',
				'mode' => 'enable',
				'avatar' => 'default.png',
				'creation_date' => getCurrentDate("Y-m-d")
			);
			sendEmail($dataReceiveFromPost);
			$this->db->insert("myuser", $params);
			return $this->db->insert_id();
        }
	}


	public function massivelyCreateUsers($excelFileWithUsers){
		$this->load->library('excel');
		$fileTemporaryName = $excelFileWithUsers['tmp_name'];
		$object = PHPExcel_IOFactory::load($fileTemporaryName);
		$highestColumn = $object->setActiveSheetIndex(0)->getHighestColumn();
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

		//valid column size 
		if($highestColumnIndex == 4){
			foreach($object->getWorksheetIterator() as $worksheet){
				$highestRow = $worksheet->getHighestRow();			
				for($row=2; $row<=$highestRow; $row++)
				{
					$name = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					$email = $worksheet->getCellByColumnAndRow(1, $row)->getValue(); 
					$password = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$roleExcel = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
					$roleExcel == 'instructor' ? $role = "Instructor" : $role = "Student";
					$passmd5 = md5($password);	
					$params = array(
						'name' => $name,
						'email' => $email,
						'role' => $role,
						'password' => $password,
						'template-email' => 'register',
						'subject' => 'email-account-created'
					);
					$this->create($params);
				}
			}	
			return true;
		}else{
			return false;
		}
	}

	
    public function listing(){
        $this->db->select("T0.id,T0.name,T0.email,T1.name as role");
		$this->db->from("myuser T0");
		$this->db->join("myrole T1", "T0.myrole_id = T1.id");
		$this->db->where('T0.excluded', NULL);
		$this->db->where("T0.id !=", 1);
        $query = $this->db->get();
        if($query->num_rows() > 0){
			return $query->result();
        }
    }
	
	
	public function delete($userId){
		$this->db->where("myuser_id", $userId);
		if($this->db->delete("relationship") == false){
			return false;
		}

		$this->db->where("myuser_id", $userId);
		if($this->db->delete("lesson_status") == false){
			return false;
		}

		$this->db->where("myuser_id", $userId);
		if($this->db->delete("myuser_has_certificate") == false){
			return false;
		}

		$this->db->where("myuser_id", $userId);
		if($this->db->delete("myuser_has_social_networks") == false){
			return false;
		}

		$this->db->where("myuser_id", $userId);
		if($this->db->delete("payments") == false){
			return false;
		}

		$this->db->where("myuser_id", $userId);
		if($this->db->delete("users_answers") == false){
			return false;
		}

		$this->db->where("id", $userId);
		if($this->db->delete("myuser") == false){
			return false;
		}

		return true;
    }

	
	public function getUserProfile(){
		$this->db->where("id",  getUserId() );
		$query = $this->db->get("myuser");
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;
		}
	}	

	public function get($userId){
		$this->db->where("id",  $userId );
		$query = $this->db->get("myuser");
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;
		}
	}	

	public function getUserExams($userId){
		$this->db->select("T0.score,T1.title as exam, T2.title as course, T1.id, T1.approval");
		$this->db->from("lesson_status T0");
		$this->db->join("mylesson T1", "T0.mylesson_id = T1.id");
		$this->db->join("mycourse T2", "T0.mycourse_id = T2.id");
		$this->db->where("T1.type_mylesson_id", 8);
		$this->db->where("T0.myuser_id", $userId);
		$this->db->where("T0.status", "finished");
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}
	}

	

	public function getInstructors($courseId){
		$this->db->select("T1.name,T1.description,T1.avatar");
		$this->db->from("relationship T0");
		$this->db->join("myuser T1" , "T0.myuser_id = T1.id ");
		$this->db->where("T1.myrole_id = 2 AND T0.mycourse_id = ".$courseId." ");
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}
	}

	public function getEnrolledCourses($userId){
		$this->db->select("T1.id,T1.title");
        $this->db->distinct();
        $this->db->from("relationship T0");
        $this->db->join("mycourse T1", "T0.mycourse_id = T1.id");
        $this->db->where("T0.myuser_id", $userId);
        $this->db->where("T0.mycourse_id !=",  1);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
	}

	public function getEnrolledPrograms($userId){
		$this->db->select("T1.id,T1.title");
        $this->db->distinct();
        $this->db->from("relationship T0");
        $this->db->join("program T1", "T0.program_id = T1.id");
        $this->db->where("T0.myuser_id", $userId);
        $this->db->where("T0.program_id !=",  1);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
	}

	public function getNotEnrolledCourses($userId){
        $this->db->select("T1.id as key,T1.title as label");
        $this->db->distinct();
        $this->db->from("relationship T0");
        $this->db->join("mycourse T1", "T0.mycourse_id = T1.id");
        $this->db->where("T0.myuser_id !=", $userId);
        $this->db->where("T0.mycourse_id NOT IN (SELECT mycourse_id FROM relationship WHERE myuser_id = ".$userId.")", null, false);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
	}

	public function getNotEnrolledPrograms($userId){
        $this->db->select("T1.id as key,T1.title as label");
        $this->db->distinct();
        $this->db->from("relationship T0");
        $this->db->join("program T1", "T0.program_id = T1.id");
        $this->db->where("T0.myuser_id !=", $userId);
        $this->db->where("T0.program_id NOT IN (SELECT program_id FROM relationship WHERE myuser_id = ".$userId.")", null, false);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
	}
	
	public function enrollUserIntoCourses($userId,$courses){
		foreach($courses as $courseId){
            $this->Course_Model->enrollUserIntoCourse($courseId,$userId);
        }
	}

	public function enrollUserIntoPrograms($userId,$programs){
		foreach($programs as $programId){
            $this->Program_Model->enrollUserIntoProgram($programId,$userId);
        }
	}

	public function getUserRole($userId){
		$this->db->select("myrole_id");
		$this->db->from("myuser");
		$this->db->where("id", $userId);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result()[0]->myrole_id;
		}
	}

	public function editProfile($userId, $data){
		$this->db->where("id", $userId);
		if($this->db->update("myuser", $data)){
			return true;
		}else{
			return false;
		}
	}

}