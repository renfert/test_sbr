<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Course_Model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('User_Model');
    $this->load->model('Verify_Model');
    $this->load->model('Lesson_Model');
    $this->load->model('Category_Model');
    $this->load->model("Filters_Model");
  }



  public function create($dataReceiveFromPost)
  {
    finishStep(2);

    $this->db->insert("mycourse", $dataReceiveFromPost);
    $courseId =  $this->db->insert_id();
    $this->Activity_Model->save("course-created", $courseId, 1, null, 1, null, null, null, null);


    /* Enroll adm in a course */
    $this->enrollUserIntoCourse($courseId, 1);

    /* Enroll user creator*/
    if (getUserId() != 1) {
      $this->enrollUserIntoCourse($courseId, getUserId());
    }

    return $courseId;
  }




  public function listing()
  {
    $currentDate = getCurrentDate("Y-m-d");
    $this->db->select("
            T0.id,
            T0.title,
            T0.photo,
            T0.validity,
            T2.enroll_date,
            T3.edit as editPrivilege,
            T3.delete as deletePrivilege,
            DATE_FORMAT(T0.release_date, '%d/%m/%Y') as release_date,
            DATE_FORMAT(T0.expiration_date, '%d/%m/%Y') as expiration_date,
            DATEDIFF(T0.expiration_date, '$currentDate') as expirationDays,
            DATEDIFF(T0.release_date, '$currentDate') as releaseDays,
            DATEDIFF(DATE_ADD(T2.enroll_date, INTERVAL T0.validity DAY), '$currentDate' ) as validityDays,
            (SELECT count(DISTINCT mylesson_id ) - 1 FROM relationship T5 INNER JOIN mylesson T6 ON T5.mylesson_id = T6.id  WHERE T5.mycourse_id = T0.id AND T6.status IS NULL) as lessons,
            (SELECT count(DISTINCT mylesson_id) FROM lesson_status WHERE mycourse_id = T0.id AND myuser_id = " . getUserId() . " AND status = 'finished') as finishedLessons
        ");
    $this->db->distinct();
    $this->db->from("mycourse T0");
    $this->db->join("relationship T1", "T0.id = T1.mycourse_id");
    $this->db->join("course_helper T2", "T0.id = T2.mycourse_id");
    $this->db->join("user_privileges T3", "T0.id = T3.mycourse_id", "left");
    $this->db->where("T1.myuser_id", getUserId());
    $this->db->where("T0.id !=", 1);
    $this->db->where("T2.myuser_id", getUserId());
    $this->db->order_by("T0.id", "DESC");
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      foreach ($query->result() as $row) {
        if ($row->validityDays <= 0 && $row->validity != null && $row->validity != 0 && getUserId() != 1) {
          $this->removeUserFromCourse(getUserId(), $row->id);
        }
      }
      return $query->result();
    }
  }

  public function listingAll($categories, $price, $title)
  {
    $price = $this->Filters_Model->filtercoursesByPrice($price);
    $categories = $this->Filters_Model->filterCoursesByCategories($categories);
    $title = $this->Filters_Model->filterCoursesByTitle($title);

    $currentDate = getCurrentDate("Y-m-d");
    $this->db->select("
            T0.id,
            T0.title,
            T0.description,
            T0.photo,
            T0.price,
            T0.reviews,
            T0.currency,
            T0.payment_platform,
            T3.id as category,
            T0.creation_date,
            DATE_FORMAT(T0.release_date, '%d/%m/%Y') as release_date,
            DATE_FORMAT(T0.expiration_date, '%d/%m/%Y') as expiration_date,
            DATEDIFF(T0.expiration_date, '$currentDate') as expirationDays,
            DATEDIFF(T0.release_date, '$currentDate') as releaseDays,
            T0.spotlight,
            T0.validity,
            T0.preview,
            T1.name,
            T1.avatar,
            T2.currency as globalCurrency,
            (SELECT COUNT(DISTINCT mymodule_id) FROM relationship WHERE mycourse_id = T0.id AND mymodule_id != 1) as totalModules,
            (SELECT COUNT(DISTINCT mylesson_id) FROM relationship WHERE mycourse_id = T0.id AND mylesson_id != 1) as totalLessons,
            (SELECT COUNT(DISTINCT id) FROM reviews WHERE mycourse_id =  T0.id) as totalReviews,
            (SELECT SUM(rate) FROM reviews WHERE mycourse_id =  T0.id) as totalRate
            ");
    $this->db->from("mycourse T0");
    $this->db->join("myuser T1", "T0.creation_user = T1.id");
    $this->db->join("settings T2", "1 = 1");
    $this->db->join("mycategory T3", "T0.mycategory_id = T3.id");
    $this->db->where("T0.id !=", 1);
    $this->db->where_in("T0.mycategory_id", $categories);
    $this->db->where($price);
    $this->db->where($title);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
    }
  }


  public function get($courseId)
  {
    $this->db->select("*");
    $this->db->from("mycourse");
    $this->db->where("id", $courseId);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->row();
    }
  }

  public function getEnrollDate($courseId)
  {
    $this->db->select("*");
    $this->db->from("course_helper");
    $this->db->where("mycourse_id", $courseId);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
    }
  }

  public function getCourseByTitle($courseTitle)
  {
    $currentDate = getCurrentDate("Y-m-d");
    $this->db->select("
      T0.id,
      T0.title,
      T0.description,
      T0.photo,
      T0.price,
      T0.reviews,
      T0.currency,
      T0.payment_platform,
      T3.name as category,
      T0.creation_date,
      DATE_FORMAT(T0.release_date, '%d/%m/%Y') as release_date,
      DATE_FORMAT(T0.expiration_date, '%d/%m/%Y') as expiration_date,
      DATEDIFF(T0.expiration_date, '$currentDate') as expirationDays,
      DATEDIFF(T0.release_date, '$currentDate') as releaseDays,
      T0.spotlight,
      T0.validity,
      T0.preview,
      T1.name as instructorName,
      T1.description as instructorDescription,
      T1.avatar as instructorAvatar,
      (SELECT COUNT(DISTINCT mymodule_id) FROM relationship WHERE mycourse_id = T0.id AND mymodule_id != 1) as totalModules,
      (SELECT COUNT(DISTINCT mylesson_id) FROM relationship WHERE mycourse_id = T0.id AND mylesson_id != 1) as totalLessons,
      (SELECT COUNT(DISTINCT id) FROM reviews WHERE mycourse_id =  T0.id) as totalReviews,
      (SELECT SUM(rate) FROM reviews WHERE mycourse_id =  T0.id) as totalRate
      ");
    $this->db->from("mycourse T0");
    $this->db->join("myuser T1", "T0.creation_user = T1.id");
    $this->db->join("mycategory T3", "T0.mycategory_id = T3.id");
    $this->db->like("T0.title", $courseTitle);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->row();
    }
  }

  public function userProgress($courseId, $studentId)
  {
    $lessons = $this->getLessonsListFromCourse($courseId);
    $lessonList = $lessons["lessons"];

    $numberOfLessons = $lessons["numberOfLessons"];
    $completedLessons = $this->getLessonsCompletedByTheUserToCorrection($lessonList, $studentId);

    $percentageOfCourseCompleted = (($completedLessons * 100) / $numberOfLessons);

    return $percentageOfCourseCompleted;
  }


  public function progress($courseId)
  {
    $lessons = $this->getLessonsListFromCourse($courseId);
    $lessonList = $lessons["lessons"];

    $numberOfLessons = $lessons["numberOfLessons"];
    $completedLessons = $this->getLessonsCompletedByTheUser($lessonList);

    $percentageOfCourseCompleted = (($completedLessons * 100) / $numberOfLessons);

    return $percentageOfCourseCompleted;
  }

  public function generateCertificate($courseId, $studentId)
  {
    $course = $this->get($courseId);
    $certificate = $course->certificate;
    $courseTitle = $course->title;
    $courseId = $course->id;

    $data = array(
      'certificate' => $certificate,
      'myuser_id' => $studentId,
      'mycourse_id' => $courseId,
      'course' => $courseTitle,
      'date' => getCurrentDate("Y-m-d")
    );
    $this->db->insert("myuser_has_certificate", $data);
  }




  private function getLessonsCompletedByTheUser($responseLessons)
  {
    $where = array();

    if ($responseLessons != null) {
      foreach ($responseLessons as $value) {
        array_push($where, $value->mylesson_id);
      };
      $this->db->select("*");
      $this->db->from("lesson_status");
      $this->db->where("myuser_id", getUserId());
      $this->db->where("status", "finished");
      $this->db->where_in("mylesson_id", $where);
      $query = $this->db->get();
      if ($query->num_rows() >= 0) {
        return $query->num_rows();
      }
    }
  }

  private function getLessonsCompletedByTheUserToCorrection($responseLessons, $studentId)
  {
    $where = array();
    foreach ($responseLessons as $value) {
      array_push($where, $value->mylesson_id);
    };
    $this->db->select("*");
    $this->db->from("lesson_status");
    $this->db->where("myuser_id", $studentId);
    $this->db->where("status", "finished");
    $this->db->where_in("mylesson_id", $where);
    $query = $this->db->get();
    if ($query->num_rows() >= 0) {
      return $query->num_rows();
    }
  }

  private function getLessonsListFromCourse($courseId)
  {
    $this->db->select("T0.mylesson_id");
    $this->db->distinct();
    $this->db->from("relationship T0");
    $this->db->join("mylesson T1", "T0.mylesson_id = T1.id");
    $this->db->where("T0.mycourse_id", $courseId);
    $this->db->where("T0.mylesson_id !=", 1);
    $this->db->where("T1.status", NULL);
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
      $returnData["lessons"] = $query->result();
      $returnData["numberOfLessons"] = $query->num_rows();
      return $returnData;
    }
  }

  public function enrollUserIntoCourse($courseId, $userId)
  {
    if ($this->Verify_Model->userIsInCourse($userId, $courseId) == false) {

      /*  Enroll user into course */
      $userRole =  $this->User_Model->getUserRole($userId);
      $data = array(
        'myuser_id' => $userId,
        'mycourse_id' => $courseId,
        'mymodule_id' => 1,
        'mylesson_id' => 1,
        'mygroup_id' => 1,
        'question_id' => 1,
        'answer_id' => 1,
        'program_id' => 1
      );
      $this->db->insert("relationship", $data);

      /* Enroll this user into all lessons of this course */
      $lessons = $this->getLessonsListFromCourse($courseId);
      if ($lessons != null) {
        foreach ($lessons["lessons"] as $lesson) {
          $lessonId  = $lesson->mylesson_id;
          $this->Lesson_Model->enrollUserIntoLesson($lessonId, $courseId, $userId);
        }
      }

      /* Course helper */
      $data = array(
        "myuser_id" => $userId,
        "mycourse_id" => $courseId,
        'enroll_date' => getCurrentDate("Y-m-d")
      );
      $this->db->insert("course_helper", $data);
    }
  }

  public function enrollUsersIntoCourse($courseId, $users)
  {
    foreach ($users as $userId) {
      $this->enrollUserIntoCourse($courseId, $userId);
    }
    return true;
  }

  public function removeUserFromCourse($userId, $courseId)
  {
    $roleId = $this->User_Model->getUserRole($userId);

    /* Remove user from course */
    $this->db->where('myuser_id', $userId);
    $this->db->where('mycourse_id', $courseId);
    $this->db->where('mymodule_id', 1);
    $this->db->where('mylesson_id', 1);
    $this->db->where('mygroup_id', 1);
    $this->db->where('question_id', 1);
    $this->db->where('answer_id', 1);
    $this->db->where('program_id', 1);
    $this->db->delete("relationship");

    /* Remove user from course_helper */
    $this->db->where("myuser_id", $userId);
    $this->db->where("mycourse_id", $courseId);
    $this->db->delete("course_helper");

    /* Remove user from all lessons of this course */
    $lessons = $this->getLessonsListFromCourse($courseId);
    foreach ($lessons["lessons"] as $lesson) {
      $lessonId  = $lesson->mylesson_id;
      $deleteResult = $this->Lesson_Model->removeUserFromLesson($lessonId, $courseId, $userId);
    }

    return $deleteResult;
  }



  public function edit($dataReceiveFromPost)
  {
    $data = array(
      'title' => $dataReceiveFromPost["title"],
      'description' => $dataReceiveFromPost["description"],
      'photo' => $dataReceiveFromPost["photo"],
      'price' => $dataReceiveFromPost["price"],
      'release_date' => $dataReceiveFromPost["release_date"],
      'expiration_date' => $dataReceiveFromPost["expiration_date"],
      'spotlight' => $dataReceiveFromPost["spotlight"],
      'validity' => $dataReceiveFromPost["validity"],
      'preview' => $dataReceiveFromPost["preview"],
      'reviews' => $dataReceiveFromPost["reviews"],
      'mycategory_id' => $dataReceiveFromPost["mycategory_id"],
      'certificate' => $dataReceiveFromPost["certificate"],
      'currency' => $dataReceiveFromPost["currency"],
      'payment_platform' => $dataReceiveFromPost["payment_platform"]
    );
    $this->db->where("id", $dataReceiveFromPost["id"]);
    if ($this->db->update("mycourse", $data)) {
      $this->Activity_Model->save("course-edited", $dataReceiveFromPost["id"], 1, null, 1, null, null, null, null);
      return true;
    } else {
      return false;
    }
  }

  public function delete($courseId)
  {
    $courseTitle = $this->get($courseId)->title;
    $this->Activity_Model->save("course-deleted", 1, 1, null, 1, $courseTitle, null, null, null);

    /* Delete from program_has_mycourse */
    $this->db->where("mycourse_id", $courseId);
    if ($this->db->delete("program_has_mycourse") == false) {
      return false;
    }

    /* Delete from lesson_status */
    $this->db->where("mycourse_id", $courseId);
    if ($this->db->delete("lesson_status") == false) {
      return false;
    }

    /* Delete from activities */
    $this->db->where("mycourse_id", $courseId);
    if ($this->db->delete("activities") == false) {
      return false;
    }

    /* Delete from relationship */
    $this->db->where("mycourse_id", $courseId);
    if ($this->db->delete("relationship") == false) {
      return false;
    }

    /* Delete from payments */
    $this->db->where("mycourse_id", $courseId);
    if ($this->db->delete("payments") == false) {
      return false;
    }

    /* Delete from course_helper */
    $this->db->where("mycourse_id", $courseId);
    if ($this->db->delete("course_helper") == false) {
      return false;
    }

    /* Delete from reviews */
    $this->db->where("mycourse_id", $courseId);
    if ($this->db->delete("reviews") == false) {
      return false;
    }

    /* Delete from mycourse */
    $this->db->where("id", $courseId);
    if ($this->db->delete("mycourse") == false) {
      return false;
    }

    return true;
  }

  public function getPersonsOutsideTheCourse($courseId)
  {
    $this->db->select("T0.id as key, T0.name as label");
    $this->db->distinct();
    $this->db->from("myuser T0");
    $this->db->where("T0.id not in (SELECT myuser_id FROM relationship WHERE mycourse_id = $courseId)");
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
    }
  }


  public function updateCourseStatus($courseId, $studentId, $status)
  {
    if ($status == "finished") {
      $data = array(
        "status" => "finished",
        "end_date" => getCurrentDate("Y-m-d")
      );
    } else {
      $data = array(
        "status" => "in_progress"
      );
    }

    $this->db->where("myuser_id", $studentId);
    $this->db->where("mycourse_id", $courseId);
    $this->db->update("course_helper", $data);
  }

  public function getCourseCreator($courseId)
  {
    $this->db->select("T1.name, T1.email,T1.avatar");
    $this->db->from("mycourse T0");
    $this->db->join("myuser T1", "T0.creation_user = T1.id");
    $this->db->where("T0.id", $courseId);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result()[0];
    }
  }

  public function changeCourseEditingPrivileges($courseId, $userId, $privilegeStatus)
  {
    $this->db->select("*");
    $this->db->from("user_privileges");
    $this->db->where("myuser_id", $userId);
    $this->db->where("mycourse_id", $courseId);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      $data = array(
        "edit" => $privilegeStatus
      );
      $this->db->where("myuser_id", $userId);
      $this->db->where("mycourse_id", $courseId);
      $this->db->update("user_privileges", $data);
    } else {
      $data = array(
        "myuser_id" => $userId,
        "mycourse_id" => $courseId,
        "program_id" => 1,
        "edit" => "on"
      );
      $this->db->insert("user_privileges", $data);
    }
  }

  public function changeCourseDeletePrivileges($courseId, $userId, $privilegeStatus)
  {
    $this->db->select("*");
    $this->db->from("user_privileges");
    $this->db->where("myuser_id", $userId);
    $this->db->where("mycourse_id", $courseId);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      $data = array(
        "delete" => $privilegeStatus
      );
      $this->db->where("myuser_id", $userId);
      $this->db->where("mycourse_id", $courseId);
      $this->db->update("user_privileges", $data);
    } else {
      $data = array(
        "myuser_id" => $userId,
        "mycourse_id" => $courseId,
        "program_id" => 1,
        "delete" => "on"
      );
      $this->db->insert("user_privileges", $data);
    }
  }
}
