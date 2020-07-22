<?php 
    function finishStep($stepId){
        $CI =& get_instance();
		$data = array(
			"status" => "finished"
		);
		$CI->db->where("id", $stepId);
		$CI->db->update("first_steps", $data);    
    }
?>

