<?php 
    function getCurrentDate($format){
        $CI =& get_instance();
        $CI->db->select("*");
        $CI->db->from("settings");
        $query = $CI->db->get();
        if($query->num_rows() > 0){
            $zone = $query->result()[0]->zone;
        }
        date_default_timezone_set($zone);
        return date($format);
    }
?>

