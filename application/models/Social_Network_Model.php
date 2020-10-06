<?php


class Social_Network_Model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }

  public function getPublications()
  {

    $this->db->select("T0.id,T0.myuser_id,T1.name username,T1.avatar,T0.mygroup_id,T0.mycourse_id, T3.title course_name,T0.pub_url,T0.description,
    T0.media_path,T0.media_realname,T0.media_type,T2.name group_name,T0.created,T0.modified");
    $this->db->from("social_publications T0");
    $this->db->join("myuser T1", "T1.id=T0.myuser_id");
    $this->db->join("mygroup T2", "T2.id=T0.mygroup_id");
    $this->db->join("mycourse T3", "T3.id=T0.mycourse_id");
    $this->db->where("T0.id !=", 1);
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


  public function getLikes($publication_id)
  {
    $this->db->select("*");
    $this->db->from("social_likes");
    $this->db->where("social_publication_id", $publication_id);
    return $this->db->get()->result();
  }


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

  public function getLikeByPublicationId($social_publication_id, $myuser_id)
  {
    $this->db->select("*");
    $this->db->from("social_likes");
    $this->db->where("social_publication_id", $social_publication_id);
    $this->db->where("myuser_id", $myuser_id);
    return $this->db->get()->result()[0];
  }

  public function getUsersWithStatusOn()
  {
    $mydate = getCurrentDate("Y-m-d H:i:s");
    $this->db->select("*");
    $this->db->from("myuser U");
    $this->db->where("last_activity > '" . $mydate . "' - INTERVAL 5 MINUTE");
    return $this->db->get()->result() ?: false;
  }


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

  public function deleteCommentById($comment_id)
  {
    $this->db->where("id", $comment_id);
    $this->db->delete("social_comments");
    return true;
  }

  public function editPublication($publicationEntity)
  {
    $now = getCurrentDate("Y-m-d H:i:s");
    $data = array(
      'description' => $publicationEntity["publication"],
      'media_path' => $publicationEntity["media_path"],
      "media_realname" => $publicationEntity["media_name"],
      "media_type" => $this->get_file_extension($publicationEntity["media_path"]),
      "modified" => $now
    );
    $this->db->where("id", $publicationEntity["id"]);
    if ($this->db->update("social_publications", $data)) {
      return true;
    } else {
      return false;
    }
  }

  public function get_file_extension($file_name)
  {
    return substr(strrchr($file_name, '.'), 1);
  }

  public function getAllGroups()
  {
    $this->db->select("*");
    $this->db->from("mygroup");
    return $this->db->get()->result() ?: false;
  }

  public function getAllCourses()
  {
    $this->db->select("*");
    $this->db->from("mycourse");
    $this->db->where("id !=", 1);
    return $this->db->get()->result() ?: false;
  }

  public function getPublicationsByGroupId($group_id, $myuser_id)
  {
    $this->db->select("T0.id,T0.myuser_id,T1.name username,T0.mygroup_id,T0.mycourse_id, T3.title course_name,T0.pub_url,T0.description,
    T0.media_path,T0.media_realname,T0.media_type,T2.name group_name,T0.created,T0.modified");
    $this->db->from("social_publications T0");
    $this->db->join("myuser T1", "T1.id=T0.myuser_id");
    $this->db->join("mygroup T2", "T2.id=T0.mygroup_id");
    $this->db->join("mycourse T3", "T3.id=T0.mycourse_id");
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
        $this->db->where("myuser_id", $myuser_id);
        $q->i_like_it = $this->db->get()->result() ? true : false;
      }
      return $res;
    } else return null;
  }

  public function getPublicationsByCourseId($course_id, $myuser_id)
  {
    $this->db->select("SP.id,SP.myuser_id,U.name username,SP.mygroup_id,SP.mycourse_id, C.title course_name,SP.pub_url,SP.description,
    SP.media_path,SP.media_realname,SP.media_type,G.name group_name,SP.created,SP.modified");
    $this->db->from("social_publications SP");
    $this->db->join("myuser U", "U.id=SP.myuser_id");
    $this->db->join("mygroup G", "G.id=SP.mygroup_id");
    $this->db->join("mycourse C", "C.id=SP.mycourse_id");
    $this->db->where("course_id", $course_id);
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
        $this->db->where("myuser_id", $myuser_id);
        $q->i_like_it = $this->db->get()->result() ? true : false;
      }
      return $res;
    } else return null;
  }
}
