<?php
// @package LR-PHP
// @copyright 2011 Jeffrey Hill
// @license Apache 2.0 License http://www.apache.org/licenses/LICENSE-2.0.html
defined('LREXEC') or die('Access Denied');

class LRPublish extends LRService
{
    protected function add()
    {
        parent::setActivity('add');
        parent::execute();
        $response = parent::getResponse();
        return (int) $response->DATA;
    }
    
    protected function obtain()
    {
        parent::setActivity('obtain');
        parent::execute();
        return parent::getResponse();
    }
    
    protected function publish()
    {
        parent::setActivity('publish');
        parent::execute();
        return parent::getResponse('array');
    }
    
}