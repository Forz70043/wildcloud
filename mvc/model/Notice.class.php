<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/common/inclusioni.php");


class Notice extends SessionSingleton
{
	public $success=array();
	public $error=array();
	public $warning=array();

	public function __construct() {}
	
	public function getNotice($type,$context='')
	{
		$notice=self::getInstance('Notice');
		$msg=array();
		switch($type)
		{
			case "success":
				if(array_key_exists($context,$notice->success)) {
					$msg=$notice->success[$context];
					$notice->success[$context]=array();
				}
				break;
			case "error":
				if(array_key_exists($context,$notice->error)) {
					$msg=$notice->error[$context];
					$notice->error[$context]=array();
				}
				break;
			case "warning":
				if(array_key_exists($context,$notice->warning)) {
					$msg=$notice->warning[$context];
					$notice->warning[$context]=array();
				}
				break;
			default:
				return false;
		}
		return $msg;		
	}

	public function addError($m,$context='')
	{
		self::getInstance('Notice')->error[$context][]=$m;
	}

	public function getError($context='')
	{
		return $this->getNotice('error',$context);
	}

	public function hasError($context='')
	{
		$notice=self::getInstance('Notice');
		if(array_key_exists($context,$notice->error)) {
			return sizeof($notice->error[$context])>0;
		}
		return false;
	}
	
	public function addSuccess($m,$context='')
	{
		self::getInstance('Notice')->success[$context][]=$m;
	}

	public function getSuccess($context='')
	{
		return $this->getNotice('success',$context);
	}
	
	public function hasSuccess($context='')
	{
		return sizeof(self::getInstance('Notice')->success[$context]);
	}

	public function addWarning($m,$context='')
	{
		self::getInstance('Notice')->warning[$context][]=$m;
	}

	public function getWarning($context='')
	{
		return $this->getNotice('warning',$context);
	}
	
	public function hasWarning($context='')
	{
		return sizeof(self::getInstance('Notice')->warning[$context]);
	}
};

?>