<?php

//session_start();

include_once("../common/inclusioni.php");

$secureimage= new Securimage();
$smarty = new SmartyEngine();
/*
$smarty->setTemplateDir('../includes/Smarty/templates');
$smarty->setCompileDir('../includes/Smarty/templates_c');
$smarty->setCacheDir('../includes/Smarty/cache');
$smarty->setConfigDir('../includes/Smarty/configs');
*/
$smarty->assign('dateTime',date('d-m-Y H:i:s'));
$smarty->display('login.tpl');

if(isset($_POST['submit'])){
    /*
        if($secureimage->check($_POST['security_code']) ==true || (defined('ENV_DEVEL'))){
            connectDB();
        }
        else{
            $esito = _("Codice di sicureza errato");
        }
    */
}   

?>