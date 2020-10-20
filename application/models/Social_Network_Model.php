<?php


class Social_Network_Model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }

  /*
  =============================================
  Get all publications
  ==============================================
  */
  public function getPublications()
  {

    $this->db->select("T0.id,T0.myuser_id,T1.name username,T1.avatar,T0.mygroup_id,T0.mycourse_id, T3.title course_name,T0.pub_url,T0.description,
    T0.media_path,T0.media_realname,T0.media_type,T2.name group_name,T0.created,T0.modified");
    $this->db->from("social_publications T0");
    $this->db->join("myuser T1", "T1.id=T0.myuser_id");
    $this->db->join("mygroup T2", "T2.id=T0.mygroup_id");
    $this->db->join("mycourse T3", "T3.id=T0.mycourse_id");
    $this->db->where("T0.id !=", 1);
    $this->db->where("T0.mycourse_id", 1);
    $this->db->where("T0.mygroup_id", 1);
    $this->db->order_by("created", "DESC");
    $query = $this->db->get();
    if ($res = $query->result()) {
      foreach ($res as $q) {
        $this->db->select("count(*) likes");
        $this->db->from("social_likes");
        $this->db->where("social_publication_id", $q->id);
        $q->likes = $this->db->get()->result()[0]->likes;
        $this->db->select("*");
        $this->db->from("social_likes");
        $this->db->where("social_publication_id", $q->id);
        $this->db->where("myuser_id", getUserId());
        $q->i_like_it = $this->db->get()->result() ? true : false;
      }
      return $res;
    } else return null;
  }


  /*
  =============================================
  Get all comments from specific publication
  ==============================================
  */
  public function getCommentsByPublicationId($publication_id, $myuser_id)
  {
    $this->db->select("T0.comment, T0.created, T0.modified, T1.name username, T1.avatar,T1.id myuser_id, T1.myrole_id , T0.id");
    $this->db->from("social_comments T0");
    $this->db->join("myuser T1", "T1.id=T0.myuser_id");
    $this->db->join("social_publications SP", "SP.id=T0.social_publication_id");
    $this->db->where("social_publication_id", $publication_id);
    $this->db->order_by("created", "DESC");
    if ($res = $this->db->get()->result()) {
      foreach ($res as $q) {
        $this->db->select("count(*) likes");
        $this->db->from("social_likes");
        $this->db->where("social_comment_id", $q->id);
        $q->likes = $this->db->get()->result()[0]->likes;
        $this->db->select("*");
        $this->db->from("social_likes");
        $this->db->where("social_comment_id", $q->id);
        $this->db->where("myuser_id", $myuser_id);
        $q->i_like_it = $this->db->get()->result() ? true : false;
      }
      return $res;
    }
    return 0;
  }

  /*
  =============================================
  Get all likes from specific publication
  ==============================================
  */
  public function getLikes($publication_id)
  {
    $this->db->select("*");
    $this->db->from("social_likes");
    $this->db->where("social_publication_id", $publication_id);
    return $this->db->get()->result();
  }


  /*
  =============================================
  Save publication
  ==============================================
  */
  public function savePublication($publication)
  {
    $now = getCurrentDate("Y-m-d H:i:s");
    $publication['modified'] = $now;
    if (isset($publication['id'])) {
      $this->db->where("id", $publication['id']);
      if ($this->db->update("social_publications", $publication)) return true;
      else return false;
    } else {
      $publication['created'] = $now;
      $this->db->insert("social_publications", $publication);
      return true;
    }
  }

  /*
  =============================================
  Save comment
  ==============================================
  */
  public function saveComment($comment)
  {
    $now = getCurrentDate("Y-m-d H:i:s");
    $comment['modified'] = $now;
    if (isset($comment['id'])) {
      $this->db->where("id", $comment['id']);
      if ($this->db->update("social_comments", $comment)) return true;
      else return false;
    } else {
      $comment['created'] = $now;
      $this->db->insert("social_comments", $comment);
      return true;
    }
  }

  /*
  =============================================
  Do publication like
  ==============================================
  */
  public function savePublicationLike($socialEntity)
  {
    $now = getCurrentDate("Y-m-d H:i:s");
    if (isset($socialEntity['social_publication_id'])) {
      $this->db->select("*");
      $this->db->from('social_likes');
      $this->db->where("social_publication_id", $socialEntity['social_publication_id']);
      $this->db->where("myuser_id", $socialEntity['myuser_id']);
      if ($this->db->get()->result()) {
        echo "Boa";
        $this->db->where("social_publication_id", $socialEntity['social_publication_id']);
        $this->db->where("myuser_id", $socialEntity['myuser_id']);
        $this->db->delete("social_likes");
      } else {
        $data = array(
          "social_publication_id" => $socialEntity['social_publication_id'],
          "myuser_id" => getUserId(),
          "social_comment_id" => 1,
          "created" => $now
        );
        $this->db->insert("social_likes", $data);
      }
    }
    return true;
  }

  /*
  =============================================
  Do commentary like
  ==============================================
  */
  public function saveCommentaryLike($socialEntity)
  {
    if (isset($socialEntity['social_comment_id'])) {
      $this->db->select("*");
      $this->db->where("social_comment_id", $socialEntity['social_comment_id']);
      $this->db->where("myuser_id", $socialEntity['myuser_id']);
      $this->db->from('social_likes');
      if ($this->db->get()->result()) {
        $this->db->where("social_comment_id", $socialEntity['social_comment_id']);
        $this->db->where("myuser_id", $socialEntity['myuser_id']);
        $this->db->delete("social_likes");
      } else
        $this->db->replace("social_likes", $socialEntity);
    }

    return $this->db->error();
  }



  /*
  =============================================
  Delete publication
  ==============================================
  */
  public function deletePostByPublicationId($publication_id)
  {
    // Delete from social likes
    $this->db->where("social_publication_id", $publication_id);
    $this->db->delete("social_likes");

    // Delete from social comments
    $this->db->where("social_publication_id", $publication_id);
    $this->db->delete("social_comments");

    $this->db->where("id", $publication_id);
    $this->db->delete("social_publications");
    return true;
  }

  /*
  =============================================
  Delete commentary
  ==============================================
  */
  public function deleteCommentById($comment_id)
  {
    $this->db->where("id", $comment_id);
    $this->db->delete("social_comments");
    return true;
  }

  /*
  =============================================
  Edit publication
  ==============================================
  */
  public function editPublication($publicationEntity)
  {
    $now = getCurrentDate("Y-m-d H:i:s");
    $data = array(
      'description' => $publicationEntity["publication"],
      'media_path' => $publicationEntity["media_path"],
      "media_realname" => $publicationEntity["media_name"],
      "media_type" => $this->getFileExtension($publicationEntity["media_path"]),
      "modified" => $now
    );
    $this->db->where("id", $publicationEntity["id"]);
    if ($this->db->update("social_publications", $data)) {
      return true;
    } else {
      return false;
    }
  }


  /*
  =============================================
  Get file extension
  ==============================================
  */
  private function getFileExtension($file_name)
  {
    return substr(strrchr($file_name, '.'), 1);
  }

  /*
  =============================================
  Get all publications by group
  ==============================================
  */
  public function getPublicationsByGroupId($group_id)
  {
    $this->db->select("T0.id,T0.myuser_id,T1.name username,T1.avatar,T0.mygroup_id,T0.mycourse_id, T3.title course_name,T0.pub_url,T0.description,
    T0.media_path,T0.media_realname,T0.media_type,T2.name group_name,T0.created,T0.modified");
    $this->db->from("social_publications T0");
    $this->db->join("myuser T1", "T1.id=T0.myuser_id");
    $this->db->join("mygroup T2", "T2.id=T0.mygroup_id");
    $this->db->join("mycourse T3", "T3.id=T0.mycourse_id");
    $this->db->where("T0.id !=", 1);
    $this->db->where("T0.mycourse_id", 1);
    $this->db->where("T0.mygroup_id", $group_id);
    $this->db->order_by("created", "DESC");
    $query = $this->db->get();
    if ($res = $query->result()) {
      foreach ($res as $q) {
        $this->db->select("count(*) likes");
        $this->db->from("social_likes");
        $this->db->where("social_publication_id", $q->id);
        $q->likes = $this->db->get()->result()[0]->likes;
        $this->db->select("*");
        $this->db->from("social_likes");
        $this->db->where("social_publication_id", $q->id);
        $this->db->where("myuser_id", getUserId());
        $q->i_like_it = $this->db->get()->result() ? true : false;
      }
      return $res;
    } else return null;
  }


  /*
  =============================================
  Get all publications by course
  ==============================================
  */
  public function getPublicationsByCourseId($course_id)
  {
    $this->db->select("T0.id,T0.myuser_id,T1.name username,T1.avatar,T0.mygroup_id,T0.mycourse_id, T3.title course_name,T0.pub_url,T0.description,
    T0.media_path,T0.media_realname,T0.media_type,T2.name group_name,T0.created,T0.modified");
    $this->db->from("social_publications T0");
    $this->db->join("myuser T1", "T1.id=T0.myuser_id");
    $this->db->join("mygroup T2", "T2.id=T0.mygroup_id");
    $this->db->join("mycourse T3", "T3.id=T0.mycourse_id");
    $this->db->where("T0.id !=", 1);
    $this->db->where("T0.mycourse_id", $course_id);
    $this->db->where("T0.mygroup_id", 1);
    $this->db->order_by("created", "DESC");
    $query = $this->db->get();
    if ($res = $query->result()) {
      foreach ($res as $q) {
        $this->db->select("count(*) likes");
        $this->db->from("social_likes");
        $this->db->where("social_publication_id", $q->id);
        $q->likes = $this->db->get()->result()[0]->likes;
        $this->db->select("*");
        $this->db->from("social_likes");
        $this->db->where("social_publication_id", $q->id);
        $this->db->where("myuser_id", getUserId());
        $q->i_like_it = $this->db->get()->result() ? true : false;
      }
      return $res;
    } else return null;
  }


  /*
  =============================================
  Get all courses with social feature
  ==============================================
  */
  public function getCoursesInsideSocial()
  {
    $this->db->select("*");
    $this->db->from("social_settings T0");
    $this->db->join("mycourse T1", "T0.mycourse_id = T1.id");
    $this->db->where("mycourse_id !=", 1);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
    }
  }

  /*
  =============================================
  Get all groups with social feature
  ==============================================
  */
  public function getGroupsInsideSocial()
  {
    $this->db->select("*");
    $this->db->from("social_settings T0");
    $this->db->join("mygroup T1", "T0.mygroup_id = T1.id");
    $this->db->where("T1.id !=", 1);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
    }
  }


  /*
  =============================================
  Get courses that is not in social feature
  ==============================================
  */
  public function getCoursesOutsideSocial()
  {
    $this->db->select("T0.id as key,T0.title as label");
    $this->db->distinct();
    $this->db->from("mycourse T0 ");
    $this->db->where("T0.id NOT IN (SELECT mycourse_id FROM social_settings) AND T0.id != 1", null, false);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
    }
  }

  /*
  =============================================
  Get groups that is not in social feature
  ==============================================
  */
  public function getGroupsOutsideSocial()
  {
    $this->db->select("T0.id as key,T0.name as label");
    $this->db->distinct();
    $this->db->from("mygroup T0 ");
    $this->db->where("T0.id NOT IN (SELECT mygroup_id FROM social_settings) AND T0.id != 1", null, false);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
    }
  }


  /*
  =============================================
  Save courses into social feature
  ==============================================
  */
  public function saveCoursesIntoSocial($courses)
  {
    foreach ($courses as $course) {
      $data = array(
        'mycourse_id' => $course,
        'mygroup_id' => 1,
        'program_id' => 1,
      );
      $this->db->insert("social_settings", $data);
    }
  }

  /*
  =============================================
  Save groups into social feature
  ==============================================
  */
  public function saveGroupsIntoSocial($groups)
  {
    foreach ($groups as $group) {
      $data = array(
        'mycourse_id' => 1,
        'mygroup_id' => $group,
        'program_id' => 1,
      );
      $this->db->insert("social_settings", $data);
    }
  }

  /*
  =============================================
  Remove specific course from social feature
  ==============================================
  */
  public function removeCourseFromSocial($courseId)
  {
    $this->db->where("mycourse_id", $courseId);
    $this->db->delete("social_settings");
  }

  /*
  =============================================
  Remove specific group from social feature
  ==============================================
  */
  public function removeGroupFromSocial($groupId)
  {
    $this->db->where("mygroup_id", $groupId);
    $this->db->delete("social_settings");
  }

  /*
  =============================================
  Get public network status
  ==============================================
  */
  public function getPublicNetworkStatus()
  {
    $this->db->select("*");
    $this->db->from("social_settings");
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      $socialPublicNetwork = $query->result()[0];
      if ($socialPublicNetwork->public == null) {
        $result = false;
      } else {
        $result = true;
      }
      return $result;
    }
  }

  /*
  =============================================
  Update social network status
  ==============================================
  */
  public function updatePublicNetworkStatus($currentStatus)
  {
    $this->db->select("*");
    $this->db->from("social_settings");
    $this->db->where("mycourse_id", 1);
    $this->db->where("mygroup_id", 1);
    $this->db->where("program_id", 1);
    $query = $this->db->get();
    if ($query->num_rows() == 0) {
      $data = array(
        "mycourse_id" => 1,
        "mygroup_id" => 1,
        "program_id" => 1
      );
      $this->db->insert("social_settings", $data);
    }

    if ($currentStatus == "true") {
      $status = true;
    } else {
      $status = null;
    }
    echo $status;
    $data = array(
      "public" => $status
    );
    $this->db->update("social_settings", $data);
  }

  /*
  =============================================
  Listing all courses
  ==============================================
  */
  public function listingCourses()
  {
    $this->db->select("T1.id, T1.title");
    $this->db->distinct();
    $this->db->from("social_settings T0");
    $this->db->join("mycourse T1", "T0.mycourse_id = T1.id");
    $this->db->join("relationship T2", "T1.id = T2.mycourse_id");
    $this->db->where("T0.mycourse_id !=", 1);
    $this->db->where("T2.myuser_id", getUserId());
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
    }
  }

  /*
  =============================================
  Listing all groups
  ==============================================
  */
  public function listingGroups()
  {
    $this->db->select("T1.id, T1.name");
    $this->db->distinct();
    $this->db->from("social_settings T0");
    $this->db->join("mygroup T1", "T0.mygroup_id = T1.id");
    $this->db->join("relationship T2", "T1.id = T2.mygroup_id");
    $this->db->where("T0.mygroup_id !=", 1);
    $this->db->where("T2.myuser_id", getUserId());
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
    }
  }
}
