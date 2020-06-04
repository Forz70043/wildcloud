<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/common/inclusioni.php");

class Authorizzation {
	private $email;
	private $password;

	public function __construct($email){	
		$this->email = $email;
		$this->data = $this->isAuthorized();
	}

	public function isAuthorized() {
		if(($user=User::find("email='".$this->email."'"))!==false) return $user[0]->getData();
		else return false;
	}


	public static function hasRead(){
		return $_SESSION['privileges'][$_SESSION['CURRENT_AREA']]=='r';
	}

	public static function hasReadWrite()
	{
		return $_SESSION['privileges'][$_SESSION['CURRENT_AREA']]=='rw';
	}

	public function getRoles()
	{	
		$db = new MysqlConnection();
		if(!is_numeric($this->data["id"])) return false;
		else
		{
			$query = "SELECT * FROM ROLE AS r JOIN USER_ROLE AS ur ON ur.role_id=r.id AND ur.user_id='".$this->data["id"]."' ORDER BY r.id ASC";
			if(!$res = $db->query($query)) throw new Exception("Mysql Error ".mysqli_error());
			if(!mysqli_num_rows($res)) return false;
			$roles = array();			
			while($info = mysqli_fetch_assoc($res)){ $roles[]=$info; }	
			
			return $roles;
		}
	}

	public static function getCompanyIds()
	{
		if(isset($_SESSION['restrictions']) && $_SESSION['restrictions']['COMPANY']!=false)
		{
			$ids=array();
			foreach($_SESSION['restrictions']['COMPANY'] as $perm) $ids[]=$perm['company_id'];
			return $ids;
		}
		return array();
	}
	
};

?>