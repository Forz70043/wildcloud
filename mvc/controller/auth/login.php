<?php

//session_start();

include_once("../../../common/inclusioni.php");

$secureimage= new Securimage();
$smarty = new SmartyEngine();
$smarty->assign('dateTime',date('d-m-Y H:i:s'));
$smarty->display('login.tpl');

error_log("XXXX REQ: ".print_r($_REQUEST,1));

if(isset($_POST['send'])){

    if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['captcha_code']) ){
        
        if(!validEmail($_POST['email'])){
            error_log("XXX email non valido");
        }
        else{
            
            if($secureimage->check($_POST['captcha_code']) ==true || (defined('ENV_DEVEL'))){
                error_log("XX codice ok");
                connectDB();
            }
            else{
                error_log("XXX codice non valido");
                $esito = _("Codice di sicureza errato");
            }
        }
    }
}   

?>