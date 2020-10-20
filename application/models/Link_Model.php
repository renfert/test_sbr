<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Link_Model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }


  /*
    =============================================
    Returns: Id of the last registered link
    ==============================================
    */
  public function create($dataReceiveFromPost)
  {
    $position = $this->getPositionForThisLink();
    $data = array(
      'title' => $dataReceiveFromPost["title"],
      'url' => $dataReceiveFromPost["url"],
      'target' => $dataReceiveFromPost["target"],
      'position' => $position
    );
    $this->db->insert("links", $data);
    $linkId =  $this->db->insert_id();
    $data = array(
      'header_id' => 1,
      'links_id' => $linkId
    );
    $this->db->insert("header_has_links", $data);
    return $linkId;
  }

  /*
    =============================================
    Get position for link
    ==============================================
    */
  private function getPositionForThisLink()
  {
    $this->db->select("count(id) as totalLinks");
    $this->db->from("links");
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      $result = $query->result();
      $numberOfLinks = $result[0]->totalLinks;
    }
    return $numberOfLinks;
  }


  /*
    =============================================
    Returns: Boolean - TRUE if the edit was successful and FALSE if not.
    ==============================================
    */
  public function edit($dataReceiveFromPost)
  {
    $data = array(
      'title' => $dataReceiveFromPost["title"],
      'url' => $dataReceiveFromPost["url"],
      'target' => $dataReceiveFromPost["target"],
    );
    $this->db->where("id", $dataReceiveFromPost["linkId"]);
    if ($this->db->update("links", $data)) {
      return true;
    } else {
      return false;
    }
  }


  /*
    =============================================
    Returns: Boolean - TRUE if the delete was successful and FALSE if not.
    ==============================================
    */
  public function delete($linkId)
  {
    /* Delete from links */
    $this->db->where('id', $linkId);
    if ($this->db->delete("links")) {
      return true;
    } else {
      return false;
    }
  }


  /*
    =============================================
    Returns: Array of objects
    ==============================================
    */
  public function listing()
  {
    $this->db->select("*");
    $this->db->from("header_has_links T0");
    $this->db->join('links T1', 'T0.links_id  = T1.id');
    $this->db->where("T0.header_id", 1);
    $this->db->order_by('position', 'ASC');
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
    }
  }


  /*
    =============================================
    Reorder positions
    ==============================================
    */
  public function reorder($links)
  {
    $x = 0;
    foreach ($links as $key => $val) {
      $linkId = $key;
      $position = $val;

      $data = array(
        'position' => $position
      );

      $this->db->where("id", $linkId);
      $this->db->update("links", $data);
    }
  }
}
