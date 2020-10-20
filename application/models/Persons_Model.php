<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Persons_Model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }


  /*
    =============================================
    Returns: Id of the last registered person
    ==============================================
    */
  public function create($testimonialId)
  {
    $position = $this->getPositionForThisPerson();
    $data = array(
      "name" => "Tom lima",
      "occupation" => "CEO / Pugmania",
      "comment" => "Simply the best customer service and attention to detail.",
      "photo" => "tom.png",
      "position" => $position
    );
    $this->db->insert("persons", $data);

    $personId =  $this->db->insert_id();

    /* Insert into testimonial_has_persons */
    $data = array(
      'testimonial_id' => $testimonialId,
      'persons_id' => $personId
    );
    $this->db->insert("testimonial_has_persons", $data);
    return $personId;
  }

  /*
    =============================================
    Get position for link
    ==============================================
    */
  private function getPositionForThisPerson()
  {
    $this->db->select("count(id) as totalPersons");
    $this->db->from("persons");
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      $result = $query->result();
      $numberOfPersons = $result[0]->totalPersons;
    }
    return $numberOfPersons;
  }


  /*
    =============================================
    Returns: Boolean - TRUE if the edit was successful and FALSE if not.
    ==============================================
    */
  public function edit($dataReceiveFromPost)
  {
    $data = array(
      'name' => $dataReceiveFromPost["name"],
      'occupation' => $dataReceiveFromPost["occupation"],
      'comment' => $dataReceiveFromPost["comment"],
      'photo' => $dataReceiveFromPost["avatar"]
    );
    $this->db->where("id", $dataReceiveFromPost["personId"]);
    if ($this->db->update("persons", $data)) {
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
  public function delete($personId)
  {
    /* Delete from persons */
    $this->db->where('id', $personId);
    if ($this->db->delete("persons")) {
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
  public function listing($testimonialId)
  {
    $this->db->select("*");
    $this->db->from("testimonial_has_persons T0");
    $this->db->join("persons T1", "T0.persons_id  = T1.id");
    $this->db->where("T0.testimonial_id", $testimonialId);
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
  public function reorder($persons)
  {
    $x = 0;
    foreach ($persons as $key => $val) {
      $personId = $key;
      $position = $val;

      $data = array(
        'position' => $position
      );

      $this->db->where("id", $personId);
      $this->db->update("persons", $data);
    }
  }
}
