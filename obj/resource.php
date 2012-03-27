<?php
// @package LR-PHP
// @copyright 2012 Jeffrey Hill/Jason Hoekstra
// @license Apache 2.0 License http://www.apache.org/licenses/LICENSE-2.0.html
defined('LREXEC') or die('Access Denied');

require_once(LRDIR.DS.'obj'.DS.'parsers'.DS.'parser.php');

class LRResource
{
	protected $parser;
	
	public function __construct($data, $parser = '')
	{
		$this->parser = LRParser::init($parser);
		$this->parser->setData($data);
	}
	
	/**
	 * Packages data (back) into a string for use within an LRDocument envelope
	 * @param none
	 * @return string
	 */
	public function __toString()
	{
		return $this->parser->build($this->data);
	}
}	