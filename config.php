<?php
// @package LR-PHP
// @copyright 2011 Jeffrey Hill
// @license Apache 2.0 License http://www.apache.org/licenses/LICENSE-2.0.html
defined('LREXEC') or die('Access denied');

class LRConfig
{
	private static $url = 'http://sandbox.learningregistry.org';
	const DOC_TYPE = "resource_data";
	const DOC_VERSION = "0.23.0";
	const SUBMITTER_TYPE = "agent";
	const SUBMISSION_TOS = "yes";
	const SUBMISSION_TOS_URL = "http://www.learningregistry.org/tos/cc0/v0-5";
	const GPG_METHOD = "LR-PGP.1.0";
	const GPG_OWNER = "info@tncurriculumcenter.org";
	const GPG_URL = "http://beta.tncurriculumcenter.org/GPG/public_key.txt";
	
	public static function getURL()
	{
		return self::$url;
	}
	
	public static function setURL($url)
	{
		self::$url = $url;
	}

	function __set($name, $value)
	{
		return false;
	}
}
?>