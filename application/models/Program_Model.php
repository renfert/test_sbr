<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Program_Model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('User_Model');
    $this->load->model('Verify_Model');
    $this->load->model('Lesson_Model');
    $this->load->model('Course_Model');
  }


  /* =============================================
  Create a new program
  Return: (INTEGER) : Last registered id
  ==============================================  */
  public function create($dataReceiveFromPost, $courses)
  {
    $this->db->insert("program", $dataReceiveFromPost);
    $programId =  $this->db->insert_id();
    $this->saveCoursesIntoProgram($programId, $courses);
    $this->enrollUserIntoProgram($programId, 1);
    $this->enrollUserIntoProgram($programId, getUserId());
    $this->Activity_Model->save("program-created", 1, 1, null, $programId, null, null, null, null);
    return $programId;
  }


  /* =============================================
  Edit a program
  Return: (BOOLEAN) 
  ==============================================  */
  public function edit($dataReceiveFromPost, $courses, $programId)
  {
    $programCoursesArray = $this->getCoursesInsideProgram($programId);

    /* =============================================
    Make a comparison to see if it is necessary to 
    exclude any course from the program.
    ============================================== */
    $personsEnrolledIntoProgram = $this->getAllUsersIntoProgram($programId);

    foreach ($programCoursesArray as $courseId) {
      if (!in_array($courseId, $courses)) {
        if ($personsEnrolledIntoProgram != null) {
          foreach ($personsEnrolledIntoProgram as $userId) {
            $this->Course_Model->removeUserFromCourse($userId, $courseId);
          }
        }
        $this->db->where("program_id", $programId);
        $this->db->where("mycourse_id", $courseId);
        $this->db->delete("program_has_mycourse");
      }
    }

    /* =============================================
    Make a comparison to see if it is necessary to 
    add any program course.
    ============================================== */

    foreach ($courses as $courseId) {
      if (!in_array($courseId, $programCoursesArray)) {
        if ($personsEnrolledIntoProgram != null) {
          foreach ($personsEnrolledIntoProgram as $userId) {
            $this->Course_Model->enrollUserIntoCourse($courseId, $userId);
          }
        }
        $data = array(
          'program_id' => $programId,
          'mycourse_id' => $courseId,
          'position' => 999
        );
        $this->db->insert("program_has_mycourse", $data);
      }
    }

    $this->db->where("id", $programId);
    $this->db->update("program", $dataReceiveFromPost);

    foreach ($courses as $index => $course) {
      $data = array(
        "position" => $index
      );
      $this->db->where("mycourse_id", $course);
      $this->db->update("program_has_mycourse", $data);
    }

    return true;
  }

  /* =============================================
  Get a specific program
  Return: (ARRAY) :  Array of program objects.
  ==============================================  */
  public function get($programId)
  {
    $this->db->select("*");
    $this->db->from("program");
    $this->db->where("id", $programId);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
    }
  }

  /* =============================================
  Get all courses inside a program
  Return: (ARRAY) :  Array of courses id.
  ==============================================  */
  private function getCoursesInsideProgram($programId)
  {
    $ar = array();
    $this->db->select("*");
    $this->db->from("program_has_mycourse");
    $this->db->where("program_id", $programId);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      foreach ($query->result() as $row) {
        array_push($ar, $row->mycourse_id);
      }
      return $ar;
    }
  }



  /* =============================================
  Save array of courses into a program
  Return: (BOOLEAN) 
  ==============================================  */
  public function saveCoursesIntoProgram($programId, $courses)
  {
    foreach ($courses as $index => $course) {
      $data = array(
        'program_id' => $programId,
        'mycourse_id' => $course,
        'position' => $index
      );
      $this->db->insert("program_has_mycourse", $data);
    }
  }


  /* =============================================
  Enroll a array of users into a program
  Return: (BOOLEAN) 
  ==============================================  */
  public function enrollUsersIntoProgram($programId, $users)
  {
    foreach ($users as $userId) {
      $this->enrollUserIntoProgram($programId, $userId);
    }
    return true;
  }

  /* =============================================
  Remove user from a program
  Return: (BOOLEAN) 
  ==============================================  */
  public function removeUserFromProgram($userId, $programId)
  {

    /* Remove user from program */
    $this->db->where('myuser_id', $userId);
    $this->db->where('mycourse_id', 1);
    $this->db->where('mymodule_id', 1);
    $this->db->where('mylesson_id', 1);
    $this->db->where('mygroup_id', 1);
    $this->db->where('question_id', 1);
    $this->db->where('answer_id', 1);
    $this->db->where('program_id', $programId);
    $this->db->delete("relationship");

    /* Remove user from all courses of this program */
    $courses = $this->getAllCoursesIntoProgram($programId);
    foreach ($courses as $course) {
      $courseId  = $course->id;
      $deleteResult = $this->Course_Model->removeUserFromCourse($userId, $courseId);
    }

    return $deleteResult;
  }

  /* =============================================
  Enroll a user into a program
  Return: (BOOLEAN) 
  ==============================================  */
  public function enrollUserIntoProgram($programId, $userId)
  {
    $data = array(
      'myuser_id' => $userId,
      'mycourse_id' => 1,
      'mymodule_id' => 1,
      'mylesson_id' => 1,
      'mygroup_id' => 1,
      'question_id' => 1,
      'answer_id' => 1,
      'program_id' => $programId
    );
    $this->db->insert("relationship", $data);

    $this->db->select("T1.id");
    $this->db->distinct();
    $this->db->from("program_has_mycourse T0");
    $this->db->join("mycourse T1", "T0.mycourse_id = T1.id");
    $this->db->where("T0.program_id", $programId);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      foreach ($query->result() as $row) {
        $courseId = $row->id;
        $this->Course_Model->enrollUserIntoCourse($courseId, $userId);
      }
    }
  }

  /* =============================================
  List all programs for the currently logged in user
  Return: (ARRAY) : Array of arrays of program objects. 
  ==============================================  */
  public function listing()
  {
    $currentDate = getCurrentDate("Y-m-d");
    $this->db->select("
            T1.id,
            T1.title,
            T1.photo, 
            DATE_FORMAT(T1.release_date, '%d/%m/%Y') as release_date, 
            DATE_FORMAT(T1.expiration_date, '%d/%m/%Y') as expiration_date, 
            DATEDIFF(T1.expiration_date, '$currentDate') as expirationDays,
            DATEDIFF(T1.release_date, '$currentDate') as releaseDays,
            (SELECT count( DISTINCT T3.mylesson_id) FROM program_has_mycourse T2 INNER JOIN lesson_status T3 ON T2.mycourse_id = T3.mycourse_id WHERE T2.program_id = T1.id ) as lessons,
            (SELECT count( DISTINCT T3.mylesson_id) FROM program_has_mycourse T2 INNER JOIN lesson_status T3 ON T2.mycourse_id = T3.mycourse_id WHERE T2.program_id = T1.id AND T3.status = 'finished' ) as finishedLessons");
    $this->db->distinct();
    $this->db->from("relationship T0");
    $this->db->join("program T1", "T0.program_id = T1.id");
    $this->db->where("T0.myuser_id", getUserId());
    $this->db->where("T1.id !=", 1);
    $this->db->order_by("T1.id", "DESC");
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
      return $query->result();
    }
  }

  /* =============================================
  List all courses from specific program
  Return: (ARRAY) : Array of arrays of course objects. 
  ==============================================  */
  public function listingCoursesToViewProgram($programId, $userId)
  {
    $this->db->select(
      "
            T2.title as program,
            T1.title as course,
            T1.id as id,
            (SELECT DISTINCT COUNT(*) FROM lesson_status WHERE mycourse_id = T1.id AND status IS NULL AND myuser_id = $userId) as status"
    );
    $this->db->from("program_has_mycourse T0");
    $this->db->join("mycourse T1", "T0.mycourse_id = T1.id");
    $this->db->join("program T2", "T0.program_id = T2.id");
    $this->db->where("T0.program_id", $programId);
    $this->db->order_by("T0.position", "asc");
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
    }
  }


  /* =============================================
  Get all courses
  Return: (ARRAY) : Array of arrays of course objects. 
  ==============================================  */
  public function getCourses()
  {
    $this->db->select("T0.id as key, T0.title as label");
    $this->db->distinct();
    $this->db->from("mycourse T0 ");
    $this->db->join("relationship T1", "T0.id = T1.mycourse_id");
    $this->db->where("T1.myuser_id ", getUserId());
    $this->db->where("T1.mycourse_id !=", 1);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
    }
  }

  /* =============================================
  Get all courses from specific program
  Return: (ARRAY) : Array of arrays of course objects. 
  ==============================================  */
  public function getProgramCourses($programId)
  {
    $this->db->select("T1.id, T1.title, T0.position");
    $this->db->distinct();
    $this->db->from("program_has_mycourse T0 ");
    $this->db->join("mycourse T1", "T0.mycourse_id = T1.id");
    $this->db->where("T0.program_id", $programId);
    $this->db->where("T0.mycourse_id !=", 1);
    $this->db->order_by("T0.position", "asc");
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
    }
  }


  /* =============================================
  Take all users enrolled into specific program
  Return: (ARRAY) : Array of users id. 
  ==============================================  */
  private function getAllUsersIntoProgram($programId)
  {
    $this->db->select("T1.id");
    $this->db->distinct();
    $this->db->from("relationship T0");
    $this->db->join("myuser T1", "T0.myuser_id = T1.id ");
    $this->db->where("T0.program_id", $programId);
    $this->db->where("T1.id !=", 1);
    $query = $this->db->get();
    $ar = array();
    if ($query->num_rows() > 0) {
      foreach ($query->result() as $row) {
        array_push($ar, $row->id);
      }
      return $ar;
    }
  }


  /* =============================================
  Take all courses from specific program
  Return: (ARRAY) : Array of arrays of user objects. 
  ==============================================  */
  private function getAllCoursesIntoProgram($programId)
  {
    $this->db->select("T0.mycourse_id");
    $this->db->distinct();
    $this->db->from("program_has_mycourse T0");
    $this->db->where("T0.program_id", $programId);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
    }
  }


  /* =============================================
  Delete a specific program
  Return: (BOOLEAN) 
  ==============================================  */
  public function delete($programId)
  {
    /* Get all users and courses into this program */
    $users = $this->getAllUsersIntoProgram($programId);
    foreach ($users as $user) {
      $courses = $this->getAllCoursesIntoProgram($programId);
      foreach ($courses as $course) {
        $this->Course_Model->removeUserFromCourse($user, $course->mycourse_id);
      }
    }

    /* Delete from relationship */
    $this->db->where("program_id", $programId);
    $this->db->delete("relationship");

    /* Delete from program_has_mycourse */
    $this->db->where("program_id", $programId);
    $this->db->delete("program_has_mycourse");

    /* Delete from activities */
    $this->db->where("program_id", $programId);
    $this->db->delete("activities");

    /* Delete program */
    $this->db->where("id", $programId);
    $this->db->delete("program");
  }

  public function getPersonsOutsideTheProgram($programId)
  {
    $this->db->select("T0.id as key, T0.name as label");
    $this->db->distinct();
    $this->db->from("myuser T0");
    $this->db->where("T0.id not in (SELECT myuser_id FROM relationship WHERE program_id = $programId)");
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
    }
  }
}
