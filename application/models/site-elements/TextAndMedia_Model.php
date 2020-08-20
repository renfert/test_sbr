<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TextAndMedia_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /* 
    =============================================
    Returns: Id of the last registered testimonial
    ============================================== 
    */
    public function create()
    {
        $buttonId = $this->createButton();
        $data = array(
            "header" => "Default header text",
            "subheader" => "Default subheader text",
            "content" => "Lorem ipsum dolor sit, amet consectetur adipisicing elit. Placeat minus incidunt similique obcaecati eligendi quo natus cupiditate sapiente fugit dolorem iste vero vitae dolores, magnam maxime illo voluptate! Repudiandae, esse?",
            "media" => "default_text_and_media.png",
            "media_align" => "left",
            "button_id" => $buttonId,
            "button_align" => "left",
            "text_align" => "left",
        );
        $this->db->insert("text_and_media", $data);
        $textAndMediaId = $this->db->insert_id();
        $this->registerOnSectionTable($textAndMediaId);

        return $textAndMediaId;
    }

    /* 
    =============================================
    Returns: NA
    ============================================== 
    */
    private function registerOnSectionTable($textAndMediaId)
    {
        $sectionPosition = $this->getPositionForThisSection();
        $data = array(
            "position" => $sectionPosition,
            "banner_id" => 1,
            "product_list_id" => 1,
            "testimonial_id" => 1,
            "text_and_media_id" => $textAndMediaId,
            "type" => "text-and-media"
        );
        $this->db->insert("section", $data);
    }

    /* 
    =============================================
    Returns: Id of the last registered button
    ============================================== 
    */
    private function createButton()
    {
        $data = array(
            "title" => "DEFAULT BUTTON TEXT",
            "color" => "#240D3E",
            "color_hover" => "#4285f4",
            "style" => "plain"
        );
        $this->db->insert("button", $data);
        return $this->db->insert_id();
    }


    /* 
    =============================================
    Returns: Int: section position
    ============================================== 
    */
    private function getPositionForThisSection()
    {
        $this->db->select("count(id) as totalSections");
        $this->db->from("section");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result();
            $numberOfSections = $result[0]->totalSections;
        }

        return $numberOfSections;
    }



    /* 
    =============================================
    Returns: Array of objects 
    ============================================== 
    */
    public function get($sectionId)
    {
        $this->db->select("T1.header, T1.subheader, T1.id, T1.content, T1.media, T1.media_align,T1.button_align,T2.title, T2.url, T2.target, T2.color, T2.color_hover, T2.style, T1.button_id");
        $this->db->from("section T0");
        $this->db->join("text_and_media T1", "T0.text_and_media_id = T1.id");
        $this->db->join("button T2", "T1.button_id = T2.id");
        $this->db->where("T0.id", $sectionId);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    /* 
    =============================================
    Returns: Boolean - TRUE if the edit was successful and FALSE if not.
    ============================================== 
    */
    public function edit($dataReceiveFromPost)
    {
        $data = array(
            "title" => $dataReceiveFromPost["buttonTitle"],
            "url" => $dataReceiveFromPost["buttonUrl"],
            "target" => $dataReceiveFromPost["buttonTarget"],
            "color" => $dataReceiveFromPost["buttonColor"],
            "color_hover" => $dataReceiveFromPost["buttonHoverColor"],
            "style" => $dataReceiveFromPost["buttonStyle"],
        );
        $this->db->where("id", $dataReceiveFromPost["buttonId"]);
        $this->db->update("button", $data);

        $data = array(
            "media" => $dataReceiveFromPost["mediaName"],
            "media_align" => $dataReceiveFromPost["mediaAlign"],
            "subheader" => $dataReceiveFromPost["subHeader"],
            "header" => $dataReceiveFromPost["header"],
            "content" => $dataReceiveFromPost["content"],
        );
        $this->db->where("id", $dataReceiveFromPost["textAndMediaId"]);
        if ($this->db->update("text_and_media", $data)) {
            return true;
        } else {
            return false;
        }
    }
}
