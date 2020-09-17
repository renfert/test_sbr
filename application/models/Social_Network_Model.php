<?php


class Social_Network_Model extends CI_Model
{
  public $prev_description;
  public $description;
  public $media_path;
  public $media_realname;
  public $media_type;
  public $created;
  public $modified;

  public function __construct()
  {
    parent::__construct();
  }

  public function getPublications()
  {

    $this->db->select("SP.id,SP.myuser_id,U.name username,SP.group_id,SP.pub_url,SP.prev_description,SP.description,
    SP.media_path,SP.media_realname,SP.media_type,SP.created,SP.modified");
    $this->db->from("social_publications SP");
    $this->db->join("myuser U", "U.id=SP.myuser_id");
    $this->db->order_by("created","DESC");
    $query = $this->db->get();
    if ($res = $query->result()) return $res;
    else return null;

  }

  public function getCommentsByPublicationId($id)
  {
    $this->db->select("SC.id,SC.myuser_id, U.name username, SC.social_publication_id,SC.comment,SC.prev_comment,SC.created,SC.modified");
    $this->db->from("social_comments SC");
    $this->db->join("myuser U", "U.id=SC.myuser_id");
    $this->db->where("SC.social_publication_id", $id);
    $query = $this->db->get();
    return $query->result();
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

  public function saveLike($socialEntity)
  {
    if (isset($socialEntity['social_publication_id'])) {
      $this->db->where("social_publication_id", $socialEntity['social_publication_id']);
      $this->db->where("myuser_id", $socialEntity['myuser_id']);
      $this->db->delete("social_likes");
    }
    $this->db->replace("social_likes", $socialEntity);
    return true;
  }

}