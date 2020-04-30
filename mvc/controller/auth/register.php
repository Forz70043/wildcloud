<?php

include_once($_SERVER['DOCUMENT_ROOT']."/common/inclusioni.php");

$form=new RegisterForm();

if(isset($_POST['send']))
{
    if( (isset($_POST['email']) && isset($_POST['password'])) && (!empty($_POST['email']) && $_POST['password'])){
        if(validEmail($_POST['email'])){
            if(strongPassword($_POST['password'])){
                connectDB();
                
            }
            else{
                error_log('password non valida');
            }
        }
        else{
            error_log('email non valida');
        }
    }
}




$smarty->displayForm($form,'register.tpl');

?>