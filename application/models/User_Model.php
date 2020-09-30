<?php
defined('BASEPATH') or exit('No direct script access allowed');


class User_Model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
    $this->load->helper("email");
    $this->load->model('Course_Model');
    $this->load->model('Program_Model');
  }


  /* ---------------------
        Create a new user
    -----------------------*/

  public function massivelyCreateUsers($excelFileWithUsers)
  {
    $this->load->library('excel/excel');
    $fileTemporaryName = $excelFileWithUsers['tmp_name'];
    $object = PHPExcel_IOFactory::load($fileTemporaryName);
    $highestColumn = $object->setActiveSheetIndex(0)->getHighestColumn();
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

    //valid column size
    if ($highestColumnIndex == 4) {
      foreach ($object->getWorksheetIterator() as $worksheet) {
        $highestRow = $worksheet->getHighestRow();
        for ($row = 2; $row <= $highestRow; $row++) {
          $name = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
          $email = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
          $password = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
          $roleExcel = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
          $roleExcel == 'instructor' ? $role = 2 : $role = 3;
          $passmd5 = md5($password);


          /***********************
           * Verify if user exist
           ************************/
          $this->db->where("email", $email);
          $query = $this->db->get("myuser");
          if ($query->num_rows() > 0) {
          } else {
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
      }
      return true;
    } else {
      return false;
    }
  }

  /* -----------------------
        Import massively users
    ------------------------*/

  public function create($dataReceiveFromPost)
  {

    finishStep(1);
    /*-------------------------------
			Verify if user already exist
		--------------------------------*/
    $this->db->where("email", $dataReceiveFromPost["email"]);
    $query = $this->db->get("myuser");
    if ($query->num_rows() > 0 or $dataReceiveFromPost["role"] == 1) {
      return false;
    } else {
      $params = array(
        'name' => $dataReceiveFromPost["name"],
        'email' => $dataReceiveFromPost["email"],
        'password' => md5($dataReceiveFromPost["password"]),
        'myrole_id' => $dataReceiveFromPost["role"],
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

  /* ---------------------
        Listing all users
    -----------------------*/

  public function listing()
  {
    $this->db->select("T0.id,T0.name,T0.email,T1.name as role");
    $this->db->from("myuser T0");
    $this->db->join("myrole T1", "T0.myrole_id = T1.id");
    $this->db->where('T0.excluded', NULL);
    $this->db->where("T0.id !=", 1);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
    }
  }

  /* ---------------------
        Delete a user
    -----------------------*/
  public function delete($userId)
  {

    /* Delete from relationshoip */
    $this->db->where("myuser_id", $userId);
    if ($this->db->delete("relationship") == false) {
      return false;
    }

    /* Delete from lesson_status */
    $this->db->where("myuser_id", $userId);
    if ($this->db->delete("lesson_status") == false) {
      return false;
    }

    /* Delete from myuser_has_certificate */
    $this->db->where("myuser_id", $userId);
    if ($this->db->delete("myuser_has_certificate") == false) {
      return false;
    }

    /* Delete from myuser_has_social_networkds */
    $this->db->where("myuser_id", $userId);
    if ($this->db->delete("myuser_has_social_networks") == false) {
      return false;
    }

    /* Delete from payments */
    $this->db->where("myuser_id", $userId);
    if ($this->db->delete("payments") == false) {
      return false;
    }

    /* Delete from users_answers */
    $this->db->where("create_user", $userId);
    if ($this->db->delete("activities") == false) {
      return false;
    }

    /* Delete from course_helper */
    $this->db->where("myuser_id", $userId);
    if ($this->db->delete("course_helper") == false) {
      return false;
    }

    /* Delete from reviews */
    $this->db->where("myuser_id", $userId);
    if ($this->db->delete("reviews") == false) {
      return false;
    }

    /* Delete from users_answers */
    $this->db->where("myuser_id", $userId);
    if ($this->db->delete("users_answers") == false) {
      return false;
    }

    /* Delete from user_privileges */
    $this->db->where("myuser_id", $userId);
    if ($this->db->delete("user_privileges") == false) {
      return false;
    }

    $this->db->where("id", $userId);
    if ($this->db->delete("myuser") == false) {
      return false;
    }

    return true;
  }

  /* ---------------------
        Get user profile
    -----------------------*/
  public function getUserProfile()
  {
    $this->db->where("id", getUserId());
    $query = $this->db->get("myuser");
    if ($query->num_rows() > 0) {
      return $query->row();
    } else {
      return false;
    }
  }

  /* ---------------------
        Get a specific user
    -----------------------*/
  public function get($userId)
  {
    $this->db->where("id", $userId);
    $query = $this->db->get("myuser");
    if ($query->num_rows() > 0) {
      return $query->row();
    } else {
      return false;
    }
  }

  /* ---------------------
        Get all exams from specific user
    -----------------------*/
  public function getUserExams($userId)
  {
    $this->db->select("T0.score,T1.title as exam, T2.title as course, T1.id, T1.approval");
    $this->db->from("lesson_status T0");
    $this->db->join("mylesson T1", "T0.mylesson_id = T1.id");
    $this->db->join("mycourse T2", "T0.mycourse_id = T2.id");
    $this->db->where("T1.type_mylesson_id", 8);
    $this->db->where("T0.myuser_id", $userId);
    $this->db->where("T0.status", "finished");
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
    }
  }


  /* -----------------------------------------
        Get all instructors from specific course
    -------------------------------------------*/
  public function getInstructors($courseId)
  {
    $this->db->select("T1.name,T1.description,T1.avatar");
    $this->db->from("relationship T0");
    $this->db->join("myuser T1", "T0.myuser_id = T1.id ");
    $this->db->where("T1.myrole_id = 2 AND T0.mycourse_id = " . $courseId . " ");
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
    }
  }

  /* -----------------------------------------
        Get all students from specific instructor
    -------------------------------------------*/
  public function getStudents($instructorId)
  {
    $courses = array();
    $instructorCourses = $this->getEnrolledCourses($instructorId);
    if ($instructorCourses != null) {
      foreach ($instructorCourses as $row) {
        $courseId = $row->id;
        array_push($courses, $courseId);
      }

      $this->db->select("T0.myuser_id, T1.email, T1.name,T1.avatar");
      $this->db->distinct();
      $this->db->from("relationship T0 ");
      $this->db->join("myuser T1", "T0.myuser_id = T1.id");
      $this->db->where("T1.myrole_id", 3);
      $this->db->where_in("T0.mycourse_id", $courses);
      $query = $this->db->get();
      if ($query->num_rows() > 0) {
        return $query->result();
      }
    }
  }


  /* -------------------------------------------------
        Get all courses that a specific user is enrolled
    --------------------------------------------------*/
  public function getEnrolledCourses($userId)
  {
    $this->db->select("T1.id,T1.title, T2.edit, T2.delete");
    $this->db->distinct();
    $this->db->from("relationship T0");
    $this->db->join("mycourse T1", "T0.mycourse_id = T1.id");
    $this->db->join("user_privileges T2",  "T1.id = T2.mycourse_id AND T2.myuser_id = {$userId}", "left");
    $this->db->where("T0.myuser_id", $userId);
    $this->db->where("T0.mycourse_id !=", 1);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
    }
  }

  /* -------------------------------------------------
        Get all programs that a specific user is enrolled
    --------------------------------------------------*/
  public function getEnrolledPrograms($userId)
  {
    $this->db->select("T1.id,T1.title");
    $this->db->distinct();
    $this->db->from("relationship T0");
    $this->db->join("program T1", "T0.program_id = T1.id");
    $this->db->where("T0.myuser_id", $userId);
    $this->db->where("T0.program_id !=", 1);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
    }
  }

  /* ------------------------------------------------------------
        Get all courses that a specific user is not yet enrolled in
    -------------------------------------------------------------*/
  public function getNotEnrolledCourses($userId)
  {
    $this->db->select("T1.id as key,T1.title as label");
    $this->db->distinct();
    $this->db->from("relationship T0");
    $this->db->join("mycourse T1", "T0.mycourse_id = T1.id");
    $this->db->where("T0.myuser_id !=", $userId);
    $this->db->where("T1.id !=", 1);
    $this->db->where("T0.mycourse_id NOT IN (SELECT mycourse_id FROM relationship WHERE myuser_id = " . $userId . ")", null, false);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
    }
  }

  /* ------------------------------------------------------------
        Get all programs that a specific user is not yet enrolled in
    -------------------------------------------------------------*/
  public function getNotEnrolledPrograms($userId)
  {
    $this->db->select("T1.id as key,T1.title as label");
    $this->db->distinct();
    $this->db->from("relationship T0");
    $this->db->join("program T1", "T0.program_id = T1.id");
    $this->db->where("T0.myuser_id !=", $userId);
    $this->db->where("T1.id !=", 1);
    $this->db->where("T0.program_id NOT IN (SELECT program_id FROM relationship WHERE myuser_id = " . $userId . ")", null, false);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
    }
  }

  public function enrollUserIntoCourses($userId, $courses)
  {
    foreach ($courses as $courseId) {
      $this->Course_Model->enrollUserIntoCourse($courseId, $userId);
    }
  }

  /* ------------------------------------------------------------
        Enroll a specific user into a multiple courses
    -------------------------------------------------------------*/
  public function enrollUserIntoPrograms($userId, $programs)
  {
    foreach ($programs as $programId) {
      $this->Program_Model->enrollUserIntoProgram($programId, $userId);
    }
  }


  /* ------------------------------------------------------------
       Get a user role from database
    -------------------------------------------------------------*/
  public function getUserRole($userId)
  {
    $this->db->select("myrole_id");
    $this->db->from("myuser");
    $this->db->where("id", $userId);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result()[0]->myrole_id;
    }
  }

  /* ------------------------------------------------------------
        Edit user profile
    -------------------------------------------------------------*/
  public function editProfile($userId, $data)
  {
    $this->db->where("id", $userId);
    if ($this->db->update("myuser", $data)) {
      return true;
    } else {
      return false;
    }
  }

  public function statusUpdate($userId, $status)
  {
    $data['status'] = $status;
    $data['last_activity'] = getCurrentDate("Y-m-d H:i:s");
    $this->db->where("id", $userId);
    if ($this->db->update("myuser", $data)) {
      return true;
    } else {
      return false;
    }
  }
}
