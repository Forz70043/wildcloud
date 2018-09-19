<?php

function sec_session_start(){
    $session_name="sec_sesion_id";
    $secure=false; // se https impostare a true
    $httponly=true;
    init_set('session.use_only_cookies',1);
    $cookiesParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 
    session_name($session_name);
    session_start();
    session_regenerate_id();
}

function login($email,$password,$mysqli)
{
    if($stmt = $mysqli->prepare("SELECT u.id,u.username,p.password FROM USER u LEFT JOIN PSWD p ON p.user_id=u.id")){

    }
}


?>
