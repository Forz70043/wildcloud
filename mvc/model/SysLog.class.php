<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/common/inclusioni.php");

class SysLog extends Entity 
{
	const TBLNAME = 'SYSLOG';

    public static function getTitle() {
        return 'Syslog';
    }

    public static function add($action,$email='') 
    {
        if(isset($_SESSION["email"]) || $email)
        {
            $remote_ip = $_SERVER["REMOTE_ADDR"];
			$forward_ip=isset($_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:'';
            $email = isset($_SESSION["email"])?$_SESSION["email"]:$email;
            $db = new MySqlConnection();
            $con=$db->getConnection();
            $query = "INSERT INTO SYSLOG(remote_ip,forward_ip,email,action) VALUES('" .$remote_ip . "','" .mysqli_real_escape_string($con,$forward_ip) . "','" .mysqli_real_escape_string($con,$email) . "','" .mysqli_real_escape_string($con,$action) . "')";
            $result = MySqlConnection::query($query);
            
            return $result;
        }
        else return false;
    }

     public static function addEntityAction($action, $entity, $objs = array()) {
        if ($entity instanceof Entity) {
            $key = 'KEY(' . implode(',', $entity->getKey()) . ')';
            return self::add($action . ' ' . $entity->getTitle() . ': ' . $key . ' ' . $entity);
        } else {
            $id = false;
            if (!is_array($objs)) {
                $objs = array($objs);
            }
            foreach ($objs as $key => $value) {
                if (is_null($value) || $value === "") {
                    unset($objs[$key]);
                }
                if ($key === 'id') {
                    $id = "(id=" . $value . ")";
                    unset($objs[$key]);
                }
            }
            $msg = $action . ' ' . $entity . ': ';
            if ($id) {
                $msg .= $id . ' ';
            }
            $msg .= implode(',', $objs);
            return self::add($msg);
        }
    }

    public static function addCreate($entity, $objs = array()) {
        return self::addEntityAction('CREATE', $entity, $objs);
    }

    public static function addUpdate($entity, $objs = array()) {
        return self::addEntityAction('UPDATE', $entity, $objs);
    }

    public static function addDelete($entity, $objs = array()) {
        return self::addEntityAction('DELETE', $entity, $objs);
    }

    
};


?>