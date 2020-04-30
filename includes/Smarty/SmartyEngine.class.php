
<?php
include_once($_SERVER["DOCUMENT_ROOT"].'/common/inclusioni.php');

class SmartyEngine extends Smarty 
{
	public function __construct()
	{
		parent::__construct();

		$this->setTemplateDir(SMARTY_TPL_DIR);
		$this->setCompileDir($_SERVER["DOCUMENT_ROOT"].'/includes/Smarty/templates_c');
		$this->setCacheDir($_SERVER["DOCUMENT_ROOT"].'/includes/Smarty/cache');
		$this->setConfigDir($_SERVER["DOCUMENT_ROOT"].'/includes/Smarty/configs');

		$this->left_delimiter=SMARTY_L_DELIMITER;
		$this->right_delimiter=SMARTY_R_DELIMITER;
		$this->assign('app_name', 'WILDCLOUD');
		$this->assign('doc_root',$_SERVER['DOCUMENT_ROOT']);
		$this->assign('home','/');
	}

	public function display($tplname=null){
		if(isset($tplname)) $this->assign('view',$tplname);
		$tpl='index.tpl';
		return parent::display($tpl);
	}
	
	public function displayForm($form,$formTpl)
	{
		$this->assign('form',$form);
		$this->assign('formTpl','forms/'.$formTpl);
		
		$this->display('forms/base.tpl');
	}
};

?>