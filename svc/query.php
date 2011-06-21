<?php
// @package LR-PHP
// @copyright 2011 Jeffrey Hill
// @license Apache 2.0 License http://www.apache.org/licenses/LICENSE-2.0.html
defined('LREXEC') or die('Access Denied');

class LRQuery extends LRService
{
    function __construct()
    {
        parent::__construct();
        $this->action = "POST";
        $this->verbs = array('default'=>new LRRequest);
        
        $this->verbs['default']->q = array('optional','string','');
        $this->setVerb('default');
    }
}