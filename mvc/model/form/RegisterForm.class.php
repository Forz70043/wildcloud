<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/common/inclusioni.php");


class RegisterForm extends Form 
{
	public function construct(
		$fields=array(
			'email'=>'',
			'pass'=>'')
	){
		parent::__construct($fields);
		//$this->setFields($fields);
		//error_log("XXX fields ".print_r($this->getFields(),1));
		$this->setTitle('Sign Up');
	}	
};


?>