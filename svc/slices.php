<?php
// @package LR-PHP
// @copyright 2011 Jeffrey Hill
// @license Apache 2.0 License http://www.apache.org/licenses/LICENSE-2.0.html
defined('LREXEC') or die('Access Denied');

class LRSlices extends LRService
{
    function __construct()
    {
        parent::__construct();
        $this->action = "GET";
        $this->verbs = array('default'=>new LRRequest);
        
        $this->verbs['default']->any_tags = array('optional','string','');
        $this->verbs['default']->start_date = array('optional','date','');
        $this->verbs['default']->identity = array('optional','string','');
        $this->verbs['default']->full_docs = array('optional','boolean', true);
        $this->setVerb('default');
    }
}