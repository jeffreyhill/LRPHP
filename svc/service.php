<?php
// @package LR-PHP
// @copyright 2011 Jeffrey Hill
// @license Apache 2.0 License http://www.apache.org/licenses/LICENSE-2.0.html
defined('LREXEC') or die('Access denied');
require_once('..'.DS.'request.php');
require_once('..'.DS.'utility.php');

class LRService
{
    var $data;
    var $action;
    var $args;
    var $verb;
    var $verbs;
    
    public function __construct()
    {
        $this->verbs = array('default'=>new LRRequest);
    }
    
    public function setArgs($args)
    {
        foreach($args as $k=>$v)
        {
            if(!empty($this->verbs[$this->verb]->$k))
            {
                // format indicator in service declaration
                print_r($this->verbs[$this->verb]->$k);
                $format = "_".$this->verbs[$this->verb]->$k[1];
                $this->args->$k = LRUtility::$format($v);
                echo $k.'>'.$this->args->$k.'<br />';
            }
        }
    }
    
    public function unsetArgs($k)
    {
        $k = (array) $k;
        foreach($k as $kk)
        {
            if(in_array($kk, array_keys($this->verbs[$this->verb])))
            {
                unset($this->args->$kk);
            }
        }
    }
    
    public function getVerb()
    {
        return $this->verb;
    } 
    
    public function setVerb($verb)
    {
        if(!in_array($verb,array_keys($this->verbs))) return false;
        $this->verb = $verb;
    }
}
