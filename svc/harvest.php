<?php
// @package LR-PHP
// @copyright 2011 Jeffrey Hill
// @license Apache 2.0 License http://www.apache.org/licenses/LICENSE-2.0.html
defined('LREXEC') or die('Access Denied');

class LRHarvest extends LRService
{
    function __construct()
    {
        parent::__construct();
        $this->action = "POST";
        $this->verbs = array('listrecords'=>new LRRequest,'getrecord'=>new LRRequest);
        
        $this->verbs['listrecords']->from = array('optional','datetime','');
        $this->verbs['listrecords']->until = array('optional','datetime','');
        
        $this->verbs['getrecord']->request_ID = array('required','string','');
        $this->verbs['getrecord']->by_doc_ID = array('optional','boolean',true);
        $this->verbs['getrecord']->by_resource_ID = array('optional','boolean',false);
    }
}