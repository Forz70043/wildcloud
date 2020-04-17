<?php
include_once($_SERVER["DOCUMENT_ROOT"].'/common/inclusioni.php');
error_log("doc ROOT ".print_r($_SERVER["DOCUMENT_ROOT"],1));

class SmartyEngine extends Smarty 
{
	public function __construct()
	{
		parent::__construct();

		$this->setTemplateDir($_SERVER["DOCUMENT_ROOT"].'/includes/Smarty/templates');
		$this->setCompileDir($_SERVER["DOCUMENT_ROOT"].'/includes/Smarty/templates_c');
		$this->setCacheDir($_SERVER["DOCUMENT_ROOT"].'/includes/Smarty/cache');
		$this->setConfigDir($_SERVER["DOCUMENT_ROOT"].'/includes/Smarty/configs');

		$this->left_delimiter='[+';
		$this->right_delimiter='+]';
	}
};

?>