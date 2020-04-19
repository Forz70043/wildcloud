<?php
include_once($_SERVER["DOCUMENT_ROOT"].'/common/inclusioni.php');

class SmartyEngine extends Smarty 
{
	public function __construct()
	{
		parent::__construct();

		$this->setTemplateDir($_SERVER["DOCUMENT_ROOT"].'/views');
		$this->setCompileDir($_SERVER["DOCUMENT_ROOT"].'/includes/Smarty/templates_c');
		$this->setCacheDir($_SERVER["DOCUMENT_ROOT"].'/includes/Smarty/cache');
		$this->setConfigDir($_SERVER["DOCUMENT_ROOT"].'/includes/Smarty/configs');

		$this->left_delimiter='[+';
		$this->right_delimiter='+]';
		$this->assign('app_name', 'WILDCLOUD');
	}

	public function display($tpl_component=null){
		if(isset($tpl_component)) $this->assign('bodyComponents',$tpl_component);

		return parent::display('index.tpl');
	}
};

?>