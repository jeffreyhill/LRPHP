<?php
// @package LR-PHP
// @copyright 2011 Jeffrey Hill/Jason Hoekstra
// @license Apache 2.0 License http://www.apache.org/licenses/LICENSE-2.0.html
defined('LREXEC') or die('Access Denied');

class LRDocument
{	
	public $doc_type = LRConfig::DOC_TYPE;
	public $doc_version = LRConfig::DOC_VERSION;
	public $resource_data;
	public $resource_data_type;
	public $keys;
	public $TOS;
	public $payload_placement;
	public $payload_schema;
	public $active = true;
	public $resource_locator;
	public $identity = array(
		'submitter_type'=>'',
		'submitter'=>'',
		'curator'=>'',
		'owner'=>'',
		'signer'=>''
	);
	
	public $digital_signature;
	
	/*
	 * Constructor
	 * @param $doc object
	 */
	public function __construct($doc)
	{
		$this->resource_data = $doc->resource_data;
		$this->keys = $doc->keys;
		$this->TOS = $doc->TOS;
		$this->payload_placement = $doc->payload_placement;
		$this->resource_data_type = $doc->resource_data_type;
		$this->payload_schema = $doc->payload_schema;
		$this->active = $doc->active == false ? false : true;
		$this->resource_locator = $doc->resource_locator;
		$this->identity = $doc->identity;
	}
	
	public function setUUID()
	{
		if(!class_exists('UUID'))
		{
			require_once(LRDIR.DS.'lib'.DS.'uuid.php');
			UUID::initRandom();
		}
		$this->doc_id = UUID::mint(4);
	}
	
	public function sign()
	{
		require_once(LRDIR.DS.'lib'.DS.'signature.php');
		$this->digital_signature = LRSignature::sign($this);
		return true;
	}
	
	public function validate()
	{
		// TODO: Select validation of object elements
		return true;
	}
}	