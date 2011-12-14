<?php
// @package LR-PHP
// @copyright 2011 Jeffrey Hill
// @license Apache 2.0 License http://www.apache.org/licenses/LICENSE-2.0.html
defined('LREXEC') or die('Access Denied');

class LRObtain extends LRService
{
    function __construct()
    {
        parent::__construct();
        $this->action = "GET";
        $this->verbs = array('default'=>new LRRequest);
        
        $this->verbs['default']->by_doc_ID = array('optional','boolean',false);
        $this->verbs['default']->by_resource_ID = array('optional','boolean',true);
        $this->verbs['default']->ids_only = array('optional','boolean',false);
        $this->verbs['default']->resumption_token = array('optional','string','');
        $this->verbs['default']->request_ID = array('optional','string','');
        $this->setVerb('default');
    }
}