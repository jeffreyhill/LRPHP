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
        $this->request->by_doc_ID = array('optional','boolean',false);
        $this->request->by_resource_ID = array('optional','boolean',true);
        $this->request->ids_only = array('optional','boolean',false);
        $this->request->resumption_token = array('optional','string','');
        $this->request->request_IDs = array('optional','array',array());
    }
}