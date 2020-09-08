<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Filters_Model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }

  /*
    =============================================
      Return a array of categories to performe the query
    ==============================================
    */
  public function filterCoursesByCategories($categories)
  {
    if ($categories[0] == null) {
      $this->db->select("*");
      $this->db->from("mycategory");
      $query = $this->db->get();

      if ($query->num_rows() > 0) {
        $result = $query->result();
        foreach ($result as $row) {
          $categoryId  = $row->id;
          array_push($categories, $categoryId);
        }
      }
    }

    return $categories;
  }

  /*
    =============================================
      Return a string to performe the query
    ==============================================
    */
  public function filtercoursesByPrice($price)
  {
    if ($price == "free") {
      $price = "T0.price IS NULL OR T0.price = '0,00'";
    }

    if ($price == null or $price == "all") {
      $price = "1=1";
    }

    if ($price == "paid") {
      $price = "T0.price IS NOT NULL";
    }

    return $price;
  }

  /*
    =============================================
      Return a string to performe the query
    ==============================================
    */
  public function filterCoursesByTitle($title)
  {
    if ($title == null or $title == '') {
      $title = "T0.title LIKE '%'";
    } else {
      $title = "T0.title LIKE '%" . $title . "%'";
    }

    return $title;
  }

  public function filterEmptyFields($field, $rules)
  {
    if (in_array($field, $rules)) {
      return null;
    } else {
      return $field;
    }
  }
}
