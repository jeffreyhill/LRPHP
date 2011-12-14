<?php
// @package LR-PHP
// @copyright 2011 Jeffrey Hill/Jason Hoekstra
// @license Apache 2.0 License http://www.apache.org/licenses/LICENSE-2.0.html
defined('LREXEC') or die('Access Denied');

require_once(LRDIR.DS.'obj'.DS.'document.php');

class LRPublish extends LRService
{
	protected $documents = array();
	
	function __construct()
	{
		parent::__construct();
		$this->action = "POST";
		$this->setVerb('default');
	}

	function addDocument($document)
	{
		$this->documents[] = new LRDocument($document);
		return true;
	}
	
	function getArgs()
	{
		if(empty($this->documents)) return false;
		$args = '{"documents":[';
		foreach($this->documents as $document)
		{
			$document->sign();
			$args .= json_encode($document);
		}
		$args .= "]}";
		return $args;
	}
}