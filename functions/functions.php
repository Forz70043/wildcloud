<?php

function sec_session_start(){
    $session_name="sec_sesion_id";
    $secure=true; // se https impostare a true
    $httponly=true;
    ini_set('session.use_only_cookies',1);
    $cookiesParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 
    session_name($session_name);
    session_start();
    session_regenerate_id();
}

function validEmail($string){
    if(isset($string) && !empty($string)){
        if(filter_var($string,FILTER_VALIDATE_EMAIL)) return true;
        //if (!stristr($string,"@") || !stristr($string,".") ) return false;

    }
    return false;
}


/**
 * Password must be at least 8 characters in length.
 * Password must include at least one upper case letter.
 * Password must include at least one number.
 * Password must include at least one special character.
 */
function strongPassword($string){
    if(isset($string) && !empty($string)){
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
        
        if(!$uppercase || !$lowercase || !$number || !$specialChars) return false;
        else return true;
    }
    return false;
}

?>
