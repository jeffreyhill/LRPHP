<?php
// @package LR-PHP
// @copyright 2011 Jeffrey Hill
// @license Apache 2.0 License http://www.apache.org/licenses/LICENSE-2.0.html
defined('LREXEC') or die('Access Denied');

class LRSlice extends LRService
{
    function __construct()
    {
        parent::__construct();
        $this->action = "GET";
        $this->verbs = array('default'=>new LRRequest);
        
        $this->verbs['default']->any_tags = array('optional','string','');
        $this->verbs['default']->from  = array('optional','date','');
        $this->verbs['default']->until  = array('optional','date','');       
        $this->verbs['default']->identity = array('optional','string','');
        $this->verbs['default']->ids_only = array('optional','boolean', false);
        $this->verbs['default']->resumption_token = array('optional','string','');        
        $this->setVerb('default');
    }
}