<?php 
function check_empty($value){
    if(empty($value)){
        return false;
    }
    return true;
}

function valid_email($value){
    if(!filter_var($value , FILTER_VALIDATE_EMAIL)){
        return false;
    }
    return true;
}

?>