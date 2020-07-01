<?php
    function production(){
        return false;        
    }
    
    function getUserId(){
        $CI =& get_instance();
        if(production() == false){
			return 3;
		}else{
			return $CI->session->userdata("id");
		}
    }

    function activeSession(){
        $CI =& get_instance();
        if(production() == false){
            return false;
		}else{
            $sess_id = $CI->session->userdata('id');
            if($sess_id){
                return true;
            }else{
                return false;
            }
		}
    }

?>

