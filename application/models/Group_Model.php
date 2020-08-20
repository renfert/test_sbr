<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Group_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Course_Model');
        $this->load->model('Program_Model');
        $this->load->model('User_Model');
    }

    /* 
    =============================================
    General group section
    ============================================== 
    */

    public function create($groupName)
    {
        /* Verify if this group name exist */
        $this->db->where("name", $groupName);
        $query = $this->db->get("mygroup");
        if ($query->num_rows() > 0) {
            return false;
        } else {
            $data = array(
                'name' => $groupName
            );
            $this->db->insert("mygroup", $data);
            return $this->db->insert_id();
        }
    }


    public function edit($dataReceiveFromPost)
    {
        $groupName = $dataReceiveFromPost["name"];
        $groupId = $dataReceiveFromPost["id"];
        /* Verify if this group exist */
        $this->db->where("name", $groupName);
        $query = $this->db->get("mygroup");
        if ($query->num_rows() > 0) {
            return false;
        } else {
            $data = array(
                'name' => $groupName
            );
            $this->db->where("id", $groupId);
            $this->db->update("mygroup", $data);
            return true;
        }
    }


    public function delete($groupId)
    {
        $this->db->where('id', $groupId);
        if ($this->db->delete("mygroup")) {
            return true;
        } else {
            return false;
        }
    }


    public function listing()
    {
        $this->db->select("*");
        $this->db->from("mygroup");
        $this->db->where("id !=", 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }


    public function get($groupId)
    {
        $this->db->select("*");
        $this->db->from("mygroup");
        $this->db->where("id", $groupId);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
    }

    /* 
    =============================================
    This section is related to remove and enroll users into a group
    ============================================== 
    */

    public function saveUsersIntoGroup($groupId, $users)
    {
        foreach ($users as $userId) {
            $userRole = $this->User_Model->getUserRole($userId);

            $data = array(
                'myuser_id' => $userId,
                'mycourse_id' => 1,
                'mymodule_id' => 1,
                'mylesson_id' => 1,
                'mygroup_id' => $groupId,
                'question_id' => 1,
                'answer_id' => 1,
                'program_id' => 1
            );
            $this->db->insert("relationship", $data);


            $this->insertUserIntoCourses($groupId, $userId);
        }
    }

    private function insertUserIntoCourses($groupId, $userId)
    {
        $courses = $this->getCoursesInsideGroup($groupId);
        foreach ($courses as $course) {
            $courseId = $course->id;
            $this->Course_Model->enrollUserIntoCourse($courseId, $userId);
        }
    }

    public function removeUserFromGroup($userId, $groupId)
    {
        $userRole = $this->User_Model->getUserRole($userId);

        /* Remove user from group */
        $this->db->where('myuser_id', $userId);
        $this->db->where('mycourse_id', 1);
        $this->db->where('mymodule_id', 1);
        $this->db->where('mylesson_id', 1);
        $this->db->where('mygroup_id', $groupId);
        $this->db->where('question_id', 1);
        $this->db->where('answer_id', 1);
        $this->db->where('program_id', 1);

        if ($this->db->delete("relationship") == false) {
            return false;
        }

        /* Remove this user to all courses in that group */
        $courses = $this->getCoursesInsideGroup($groupId);
        foreach ($courses as $course) {
            $courseId = $course->id;
            if ($this->Course_Model->removeUserFromCourse($userId, $courseId) == false) {
                return false;
            }
        }

        return true;
    }


    /* 
    =============================================
    This section is related to students administration into group 
    ============================================== 
    */
    public function getStudentsInsideGroup($groupId)
    {
        $this->db->select("T1.id,T1.name");
        $this->db->distinct();
        $this->db->from("relationship T0");
        $this->db->join("myuser T1", "T0.myuser_id = T1.id");
        $this->db->where("T0.mygroup_id", $groupId);
        $this->db->where("T1.id !=", 1);
        $this->db->where("T1.myrole_id", 3);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    public function getStudentsOutsideGroup($groupId)
    {
        $this->db->select("T0.id as key,T0.name as label");
        $this->db->distinct();
        $this->db->from("myuser T0");
        $this->db->where("T0.myrole_id", 3);
        $this->db->where("T0.id NOT IN (SELECT myuser_id FROM relationship WHERE mygroup_id = " . $groupId . ")", null, false);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }


    /* 
    =============================================
    This section is related to instructors administration into group 
    ============================================== 
    */
    public function getInstructorsInsideGroup($groupId)
    {
        $this->db->select("T1.id,T1.name");
        $this->db->distinct();
        $this->db->from("relationship T0");
        $this->db->join("myuser T1", "T0.myuser_id = T1.id");
        $this->db->where("T0.mygroup_id", $groupId);
        $this->db->where("T1.id !=", 1);
        $this->db->where("T1.myrole_id", 2);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    public function getInstructorsOutsideGroup($groupId)
    {
        $this->db->select("T0.id as key,T0.name as label");
        $this->db->distinct();
        $this->db->from("myuser T0");
        $this->db->where("T0.myrole_id", 2);
        $this->db->where("T0.id NOT IN (SELECT myuser_id FROM relationship WHERE mygroup_id = " . $groupId . ")", null, false);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }




    /* 
    =============================================
    This section is related to courses administration into group 
    ============================================== 
    */

    public function getCoursesInsideGroup($groupId)
    {
        $this->db->select("T1.id,T1.title");
        $this->db->distinct();
        $this->db->from("relationship T0");
        $this->db->join("mycourse T1", "T0.mycourse_id = T1.id");
        $this->db->where("T0.mygroup_id", $groupId);
        $this->db->where("T0.mycourse_id !=",  1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    public function getCoursesOutsideGroup($groupId)
    {
        $this->db->select("T1.id as key,T1.title as label");
        $this->db->distinct();
        $this->db->from("relationship T0");
        $this->db->join("mycourse T1", "T0.mycourse_id = T1.id");
        $this->db->where("T0.mygroup_id !=", $groupId);
        $this->db->where("T0.mycourse_id NOT IN (SELECT mycourse_id FROM relationship WHERE mygroup_id = " . $groupId . ")", null, false);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    public function removeCourseFromGroup($courseId, $groupId)
    {

        /* Remove course from group */
        $this->db->where('mycourse_id', $courseId);
        $this->db->where('mygroup_id', $groupId);
        $this->db->where('myuser_id', 1);
        $this->db->where('mymodule_id', 1);
        $this->db->where('mylesson_id', 1);
        $this->db->where('question_id', 1);
        $this->db->where('answer_id', 1);
        $this->db->where('program_id', 1);

        if ($this->db->delete("relationship") == false) {
            return false;
        }

        /* Remove this course to all students into this group */
        $students = $this->getStudentsInsideGroup($groupId);
        foreach ($students as $student) {
            $studentId = $student->id;
            if ($this->Course_Model->removeUserFromCourse($studentId, $courseId) == false) {
                return false;
            }
        }

        return true;
    }


    public function saveCoursesIntoGroup($groupId, $courses)
    {
        foreach ($courses as $course) {
            $this->insertCourseIntoGroup($groupId, $course);
        }
    }

    private function insertCourseIntoGroup($groupId, $courseId)
    {
        $data = array(
            'myuser_id' => 1,
            'mycourse_id' => $courseId,
            'mymodule_id' => 1,
            'mylesson_id' => 1,
            'mygroup_id' => $groupId,
            'question_id' => 1,
            'answer_id' => 1,
            'program_id' => 1
        );
        $this->db->insert("relationship", $data);

        /* Enroll all students from that group into this course */
        $students = $this->getStudentsInsideGroup($groupId);
        if ($students) {
            foreach ($students as $student) {
                $studentId = $student->id;
                $this->Course_Model->enrollUserIntoCourse($courseId, $studentId);
            }
        }

        /* Enroll all instructors from that group into this course */
        $instructors = $this->getInstructorsInsideGroup($groupId);
        if ($instructors) {
            foreach ($instructors as $instructor) {
                $instructorId = $instructor->id;
                $this->Course_Model->enrollUserIntoCourse($courseId, $instructorId);
            }
        }
    }


    /* 
    =============================================
    This section is related to programs administration into group 
    ============================================== 
    */

    public function getProgramsInsideGroup($groupId)
    {
        $this->db->select("T1.id,T1.title");
        $this->db->distinct();
        $this->db->from("relationship T0");
        $this->db->join("program T1", "T0.program_id = T1.id");
        $this->db->where("T0.mygroup_id", $groupId);
        $this->db->where("T0.program_id !=",  1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    public function getProgramsOutsideGroup($groupId)
    {
        $this->db->select("T1.id as key,T1.title as label");
        $this->db->distinct();
        $this->db->from("relationship T0");
        $this->db->join("program T1", "T0.program_id = T1.id");
        $this->db->where("T0.mygroup_id !=", $groupId);
        $this->db->where("T1.id !=", 1);
        $this->db->where("T0.program_id NOT IN (SELECT program_id FROM relationship WHERE mygroup_id = " . $groupId . ")", null, false);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    public function removeProgramFromGroup($programId, $groupId)
    {

        /* Remove program from group */
        $this->db->where('mycourse_id', 1);
        $this->db->where('mygroup_id', $groupId);
        $this->db->where('myuser_id', 1);
        $this->db->where('mymodule_id', 1);
        $this->db->where('mylesson_id', 1);
        $this->db->where('question_id', 1);
        $this->db->where('answer_id', 1);
        $this->db->where('program_id', $programId);

        if ($this->db->delete("relationship") == false) {
            return false;
        }

        /* Remove this program to all students into this group */
        $students = $this->getStudentsInsideGroup($groupId);
        foreach ($students as $student) {
            $studentId = $student->id;
            if ($this->Program_Model->removeUserFromProgram($studentId, $programId) == false) {
                return false;
            }
        }

        return true;
    }


    public function saveProgramsIntoGroup($groupId, $programs)
    {
        foreach ($programs as $program) {
            $this->insertProgramIntoGroup($groupId, $program);
        }
    }

    private function insertProgramIntoGroup($groupId, $programId)
    {
        $data = array(
            'myuser_id' => 1,
            'mycourse_id' => 1,
            'mymodule_id' => 1,
            'mylesson_id' => 1,
            'mygroup_id' => $groupId,
            'question_id' => 1,
            'answer_id' => 1,
            'program_id' => $programId
        );
        $this->db->insert("relationship", $data);

        /* Enroll all students from that group into this program */
        $students = $this->getStudentsInsideGroup($groupId);
        if ($students) {
            foreach ($students as $student) {
                $studentId = $student->id;
                $this->Program_Model->enrollUserIntoProgram($programId, $studentId);
            }
        }

        /* Enroll all instructors from that group into this course */
        $instructors = $this->getInstructorsInsideGroup($groupId);
        if ($instructors) {
            foreach ($instructors as $instructor) {
                $instructorId = $instructor->id;
                $this->Program_Model->enrollUserIntoProgram($programId, $instructorId);
            }
        }
    }
}
