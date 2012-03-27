<?php
// @package LR-PHP
// @copyright 2012 Jeffrey Hill/Jason Hoekstra
// @license Apache 2.0 License http://www.apache.org/licenses/LICENSE-2.0.html
defined('LREXEC') or die('Access Denied');

class LRParser
{
	protected $data;
	protected $version;
	protected $parser;
	
	public function __construct() {}
	public function __clone() {}
	
	public function build()
	{
		return self::$data;
	}
	
	public function getVersion()
	{
		return self::$version;
	}
	
	public function init($parser)
	{
		if(!empty($parser))
		{
			require_once(LRDIR.DS.'obj'.DS.'parsers'.DS.$parser.'.php');
		}
		return self;
	}
	
	public function package()
	{
		return self::$data;
	}
	
	abstract function parse();
	
	public function setData($data)
	{
		self::$data = $data;
	}
}