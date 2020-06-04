<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/common/inclusioni.php");

class Form {

    public    $fields;
    protected $required;
    protected $url;
    protected $method='post';
    protected $actions;
    protected $notice;
    public    $title;


    public function __construct($fields=array(),$title='',$required=null)
    {
        $this->setFields($fields);
        $this->actions=array();
        $this->notice=new Notice();
    }

    public function __get($name){
        if(array_key_exists($name,$this->fields)) return $this->fields[$name];
        return false;
    }

    public function setTitle($title){
        $this->title=$title;
    }

    public function getTitle(){
        return $this->title;
    }
    
    //FOR ACTIONS
    public function setUrl($url){
        $this->url=$url;
    }
    
    public function getUrl(){
        return $this->url;
    }

    public function getMethod(){
        return $this->method;
    }
    
    public function setMethod($method){
        $this->method=$method;
    }
    
    public function getError($field='',$c='.'){
        return implode($c,$this->notice->getError($field)); 
    }

    public function getErrors($field='')
    {
        return $this->notice->getError($field);
    }

    // Gestione Azioni
    public function getActions(){
        return $this->actions;
    }

    public function addAction($name,$action,$type='',$novalidate=false){
        if($type) $action->type=$type;
        if($novalidate) $action->novalidate=true; // da vedere bene
        $this->actions[$name]=$action;
    }

    public function unsetAction($name){
        unset($this->actions[$name]);
    }

    public function setStandardActions()
    {
        $this->actions=array(
            'save'      =>  new ActionWrite(_('Salva'),true,'btn-primary save'),
            'delete'    =>  new ActionWrite(_('Elimina'),false,'btn-danger delete',"javascript: if(confirm('"._('Conferma Eliminazione?')."')) this.form.action='delete.php?confirm=1'; else return false;"),
            'reset'     =>  new Action(_('Ripristina'),false,'btn-light reset',"javascript: window.location=this.form.action;"/*window.location.href;"*/,'button'),
        );
        $this->actions['reset']->type='button';
        $this->actions['delete']->novalidate=true;
    }

    /* GENERIC METHODS FOR FIELDS */
    public function setFields($fields){
        if(!is_array($fields)) return false;
        $this->fields=$fields;
        return true;
    }

    public function setField($name,$value){
        $this->fields[$name]=$value;
    }
    public function unsetField($name){
        unset($this->fields[$name]);
    }
    public function getFields(){
        return $this->fields;
    }
    public function getField($name=''){
        if($name==='')  return $this->getFields();
        return $this->__get($name);
    }

    /* POST VALIDATE FOR ADDITIONALS/CUSTOM VALIDATION */
    public function postValidate(){
        return true;
    }

    //MUST BE COMPLETE !!!!!!!
    public function isValid(){
        $valid=true;

    }
    
    public function setRequired($fields=array()){
        $this->required=$fields;
    }


    //AGGIUNGERE ERRORI - SUCCESS - WARNING 

};


?>