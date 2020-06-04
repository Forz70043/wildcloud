<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/common/inclusioni.php");

abstract class Entity 
{
	const TBLNAME='';
    private static $fields=array();
    protected static $key=array('id');
 	protected $data;

    public function __construct($key=''){
        $this->data = $this->isKey($key);
    }

    protected function setData($data){
        $this->data=$data;
    }

	public function __get($field){
        if(array_key_exists($field,$this->data)) return $this->data[$field];
        return false;
    }

	/*public function __toString(){
    	return $this->__get('name');
    }*/

	public function getData(){
	    return $this->data;
	}

    static protected function createEntity($entity,$data){
        $new_class=new $entity();
        $new_class->setData($data);             
        return $new_class;
    }

	abstract public static function getTitle();

	public static function getTblname(){
	    $classname=get_called_class();
	    return $classname::TBLNAME;
	}


	protected static function isKey($key)
	{
        $dkey=self::getKeyname();
        if(!is_array($key) && sizeof($dkey)==1) return array($dkey[0]=>$key);
        else if(sizeof($key)==sizeof($dkey)) {
            if(!sizeof(array_diff($dkey,array_keys($key)))) return $key;
            return array_combine($dkey,$key);
        }
        return false;
    }

    public static function getKeyname(){
        $classname=get_called_class();
        return $classname::$key;
    }

    protected static function getFields(){
        $tblname=self::getTblname();
        if(!array_key_exists($tblname,self::$fields)) {
            if(($dbr=MysqlConnection::query('DESCRIBE '.$tblname))) {
                while(($r=mysqli_fetch_row($dbr))) $fields[]=$r[0];
                mysqli_free_result($dbr);
            }
            self::$fields[$tblname]=$fields;
        }
        return self::$fields[$tblname];
    }

    static public function query($tblname,$where,$order=array(),$limit='',$offset='',$fields=array())
    {
        $classname=get_called_class();
        if(($res=MysqlConnection::lista_entity($tblname,$fields,$where,$order,$limit,$offset))!==false) {
            $objs=array();
            foreach($res as $d){   
                error_log("entity create: ".print_r($d,1));
                $objs[]=static::createEntity($classname,$d);
                /*$new_class=new $classname();
                $new_class->setData($d);                                
                $objs[]=$new_class;*/
            }
            return $objs;
        }
        return false;
    }

    static public function find($where='',$order=array(),$limit='',$offset='',$fields=array()){
        $classname=get_called_class();
        return $classname::query(self::getTblname(),$where,$order,$limit,$offset,$fields);
    }

    static public function findByKey($key)
    {
        if(($where=self::isKey($key))===false) return false;
        if(($objs=self::find($where))===false) return false;
        if(sizeof($objs)) return $objs[0];
        return null;
    }

    // Database operations
    //TO DO: creare motodo per formattare le fields --> riga:101
    static public function insert($record,$on_duplicate_key_update=false,$noescape=array()){                                       
        $r=array();
        $classname=get_called_class();
        $fields=self::getFields();
        error_log("XXX insert");
        foreach($record as $field=>$value) {
            error_log("XXX field: ".print_r($field,true));
                
            if(in_array($field,$fields)) {
                $func='format'.ucfirst($field);

                if(method_exists($classname,$func)) $r[$field]=$classname::$func($value);
                else $r[$field]=$value;
            }
        }
        return MysqlConnection::insert(self::getTblname(),$r,$on_duplicate_key_update,$noescape);
    }

    public function update($record,$nokey=true){                               
        error_log("XXX entity update");
        return self::updateWhere($this->getKey(),$record,$nokey);                       
    }



};

?>