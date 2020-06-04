<?php

class MysqlConnection 
{
    public static $connection;
    public $error = array();

    protected $host, $user, $password, $database;

    public function __construct()
    {
        $this->host=DB_HOST;
        $this->user=DB_USER;
        $this->database=DB;
        $this->password=DB_PASSWORD;

        if(!$con=mysqli_connect($this->host,$this->user,$this->password,$this->database)){
            if(php_sapi_name()!='cli') die('Could not connect to DB: '.mysqli_error());
            exit(1);
        }
        mysqli_set_charset($con,'utf8');
        MysqlConnection::$connection = $con;
    }

    public function connectDB()
    {
        $this->connection=mysqli_connect($this->host,$this->user,$this->password,$this->database);
        if(!$this->connection){
            $e='Failed to connect to DB';
            $this->setError($e);
            return false;
        }
        error_log("XXX connection: ".print_r($this->connection->host_info,1));
        return $this->connection;
    }

    public function closeConnection(){
        $this->connection=null;
    }

    public static function getConnection(){
        if( !MysqlConnection::$connection ) new MysqlConnection;
        return MysqlConnection::$connection;
    }

    public static function query($query){
        //if(!$this->connection) return false;
        if(defined('MYSQL_DEBUG')){
            $t=microtime(true);
            $r=mysqli_query(self::getConnection(),$query);
            error_log(sprintf("DB: %s (%3.fms)",$query,microtime(true)-$t)); 
        }
        else $r=mysqli_query(self::getConnection(),$query);
        return $r;
    }

    public function setError($e,$arg=null){
        error_log(" Err ".(isset($arg))?$arg:':'.print_r($e,1));
    }

    //Gestione quotations mark
    public static function quote_field($field){
        if(strpos($field,'.')===false && strpos($field,'(')===false) return '`'.$field.'`';
        return $field;
    }

    // Escaping/Quoting

    static public function field($field)
    {
        if($field=='*' || ($p=strpos($field,'('))!==false) return $field; 
        if(($p=strpos($field,'.'))!==false) 
            return self::field(substr($field,0,$p)).'.'.self::field(substr($field,$p+1));
        return '`'.$field.'`';
    }

    static public function value($value)
    {
        if(is_array($value)) {
            $str='';
            list(,$v)=each($value);
            $str='('.self::value($v);
            while(list(,$v)=each($value)) $str.=','.self::value($v); 
            return $str.')';
        }
        else if($value===null) return 'NULL';
        else if($value===false) return "'0'";
        else if($value===true) return "'1'";
        else if(is_object($value)) {
            if(is_a($value,'DBValue')) return (string)$value;
            return "'".mysqli_real_escape_string(self::getConnection(),$value)."'";
        }
        else return "'".mysqli_real_escape_string(self::getConnection(),$value)."'";
    }


    public static function quote_value($value)
    {
        if(is_array($value)){
            list(,$v)=each($value);
            $str='\''.mysqli_real_escape_string(self::getConnection(),$v).'\'';
            while(list(,$v)=each($value)) {
                $str.=',\''.mysqli_real_escape_string(self::getConnection(),$v).'\'';
            }
            return ' IN ('.$str.')';
        }
        else if($value===null) return ' IS NULL';
        return '=\''.mysqli_real_escape_string(self::getConnection(),$value).'\'';
    }

    public static function formatDate($value,$datetime=true)
    {
        if($datetime) return strftime("%Y-%m-%d %H:%M:%S", $value);
        else return strftime("%Y-%m-%d", $value);
    }       

    protected static function where_fields($fields)
    {
        if(!is_array($fields)) return $fields;
        if(!sizeof($fields)) return ''; 
        error_log("XX fields: ".print_r($fields,1));
        list(,$field)=each($fields);
        error_log("XX field: ".print_r($field,1));
        if(is_array($field)) $str=$field[0].' AS '.$field[1];
        else $str=self::quote_field($field);
        while(list(,$field)=each($fields)) {
            if(is_array($field)) $str.=','.$field[0].' AS '.$field[1];
            else $str.=','.self::quote_field($field);
        }
        return $str;
    }

    public static function where_criteria($where,$bool='AND') {
        if(!sizeof($where)) return '';
        list($field,$value)=each($where);
        $c=self::quote_field($field).self::quote_value($value);
        while(list($field,$value)=each($where)) 
                $c.=' '.$bool.' '.self::quote_field($field).self::quote_value($value);
        return $c;
    }

    public static function escape($value){
        return mysqli_escape_string(self::getConnection(),$value);
    }

    protected static function query_string($tblname,$type="SELECT",$where='',$order=array(),$limit='',$offset='',$fields=array(),$groupby='',$having='') 
    {       
        switch($type){
            case "SELECT":
                $query='SELECT ';        
                if($limit) $query.=' SQL_CALC_FOUND_ROWS ';                        
                if(sizeof($fields)) $query.=self::where_fields($fields);  
                //else if(sizeof($this->fields)) $query.=self::where_fields($this->fields);       
                else $query.='*';
                break;
            case "DELETE":
                $query='DELETE ';
                break;
            default:
                return false;
        }

        $query.=' FROM '.$tblname;
        if($where) {
            $query.=' WHERE ';
            if(!is_array($where)) $query.=$where;
            else $query.=self::where_criteria($where);
        }

        if($type=='SELECT'){
            if($groupby) $query.=' GROUP BY '.$groupby;
            if($having) $query.=' HAVING '.$having;
            if(is_array($order) && sizeof($order)) {
                $query.=' ORDER BY ';
                $cond=array();
                foreach($order as $by=>$m) $cond[]=$by.' '.$m;
                $query.=implode(',',$cond);
            }
            if($limit) {
                $query.=' LIMIT ';
                if($offset) $query.=$offset.','.$limit;
                else $query.=$limit;
            }
        }
        return $query;
    }

    protected static function doquery($tblname,$type="SELECT",$where='',$order=array(),$limit='',$offset='',$fields=array(),$groupby='',$having='') 
    {
        $query=self::query_string($tblname,$type,$where,$order,$limit,$offset,$fields,$groupby,$having);
        if(($dbr=self::query($query))){
            if($type=='DELETE') return true;
            $result=array();
            while(($r=mysqli_fetch_assoc($dbr))) $result[]=$r;
            mysqli_free_result($dbr);
            return $result;
        }
        return false;
    }

    public static function foundRows(){
        $query="SELECT FOUND_ROWS() AS num";
        if(($dbr=self::query($query))){
            $result=array();
            $result=mysqli_fetch_assoc($dbr);
            mysqli_free_result($dbr);
            return $result["num"];
        }
        return false;
    }

    public static function countRows($tblname)
    {
        $query = "SELECT COUNT(*) AS num FROM ".$tblname;
        if(($dbr=self::query($query))){
            $result=array();
            $result=mysqli_fetch_assoc($dbr);
            mysqli_free_result($dbr);
            return $result["num"];
        }    
        return false;
    }

    // Gestione Transazioni
    public static function startTransaction(){
        return self::query('START TRANSACTION');
    }

    public static function commit(){
        return self::query('COMMIT');
    }

    public static function rollback(){
        return self::query('ROLLBACK');
    }

    //ERRORI
    public static function getError(){ 
        return mysqli_error(self::getConnection());
    }

    public static function getErrorNumber(){
        return mysqli_errno(self::getConnection());
    }

    static public function getErrorKey(){
        if(self::getErrorNumber()==1062) {
            if(preg_match('/Duplicate entry .* for key \'(.*)\'/',self::getError(),$m)) return $m[1];
        }
        return '';
    }

    static public function getLastError(){
        return self::getError();
    }

    static public function select_fields($fields=array())
    {
        if(!is_array($fields)) return $fields;
        if(!sizeof($fields)) return '';
        list(,$field)=each($fields);
        if(is_array($field)) $sql=self::field($field[0]).' AS '.$field[1];
        else $sql=self::field($field);
        while(list(,$field)=each($fields)) {
            if(is_array($field)) $sql.=','.self::field($field[0]).' AS '.$field[1];
            else $sql.=','.self::field($field);
        }
        return $sql;
    }
    
    //TABELLE RELAZIONATE
    static public function getLinkedEntityTableName() {
        if(preg_match_all("/`[\w]+`/",self::getError(),$matches)) {
            if(isset($matches[0][1])) return $matches[0][1];
        }
        return '';
    }
    
    public static function lista_entity($tblname,$fields=array(),$where='',$order=array(),$limit='',$offset='',$groupby=''){
        return self::doquery_join($tblname,'SELECT',$where,$order,$limit,$offset,$fields,$groupby);
    }

    protected static function doquery_join($tblname,$type="SELECT",$where='',$order=array(),$limit='',$offset='',$fields=array(),$groupby='') 
    {
        $query=self::query_string($tblname,$type,$where,$order,$limit,$offset,$fields,$groupby);
        if(($dbr=self::query($query)))
        {
            if($type=='DELETE') return true;
            $result=array();
            //error_log("XXX dbr: ".print_r($dbr,1));
            if(strpbrk(trim($tblname),', ')){
                $fields=array();
                $nf=mysqli_num_fields($dbr);
                //error_log("XXX nf: ".print_r($nf,1));
                /*
                for($i=0;$i<$nf;$i++) {
                    if(($f=mysqli_fetch_field($dbr))) {
                            $fields[]=$f->table.'.'.$f->name;
                    }
                    else $fields[]=$i;
                }*/
                while ($f=mysqli_fetch_field($dbr)) {
                    $fields[]=$f->table.'.'.$f->name;
                }
                //error_log("XXX fields: ".print_r($fields,1));
                while(($r=mysqli_fetch_row($dbr))) $result[]=array_combine($fields,$r);
                //error_log("XXX results: ".print_r($result,1));
            }
            else while(($r=mysqli_fetch_assoc($dbr))) $result[]=$r;
            mysqli_free_result($dbr);
            return $result;
        }
        return false;
    }


    static public function insert($tblname,$fields,$onupdate=false)
    {
        list($f,$v)=each($fields);
        $q1=self::field($f);
        $q2=self::value($v);
        $q3=self::field($f).'='.self::value($v);
        while(list($f,$v)=each($fields)) {
            $q1.=','.self::field($f);
            $q2.=','.self::value($v);
            $q3.=','.self::field($f).'='.self::value($v);
        }
        return self::query('INSERT INTO '.self::field($tblname).' ('.$q1.') VALUES ('.$q2.')'.($onupdate?' ON DUPLICATE KEY UPDATE '.$q3:''));
    }

    static public function update($tblname,$fields,$where='')
    {
        list($f,$v)=each($fields);
        $sqlset=self::field($f).'='.self::value($v);
        while(list($f,$v)=each($fields))
            $sqlset.=','.self::field($f).'='.self::value($v);
        return self::query('UPDATE '.self::field($tblname).' SET '.$sqlset.($where?' WHERE '.$where:''));
    }

};

//class_alias('MysqlConnection','DB');
?>