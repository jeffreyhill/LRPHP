<?php
// @package LR-PHP
// @copyright 2011 Jeffrey Hill/Jason Hoekstra
// @license Apache 2.0 License http://www.apache.org/licenses/LICENSE-2.0.html
defined('LREXEC') or die('Access Denied');

require_once('..'.DS.'obj'.DS.'document.php');

class LRPublish extends LRService
{
	
	function __construct()
	{
		parent::__construct();
		$this->action = "POST";
		$this->verbs = array('default'=>new LRRequest);
		$this->setVerb('default');
	}

	function setDocument($document)
	{
		$document = new LRDocument($document);
		$this->args = $document->toJSON();
		return true;
	}
	
}