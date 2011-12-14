<?php
// @package LR-PHP
// @copyright 2011 Jeffrey Hill
// @license Apache 2.0 License http://www.apache.org/licenses/LICENSE-2.0.html
require_once('../../lr.php');
require_once('../../config.php');

class LRPublishTest
{
	public function testPublish()
	{
		
		$doc_1 = new stdClass();
		$doc_1->resource_data = 
<<<EOD
		<nsdl_dc:nsdl_dc xmlns:nsdl_dc="http://ns.nsdl.org/nsdl_dc_v1.02/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:dct="http://purl.org/dc/terms/" xmlns:ieee="http://www.ieee.org/xsd/LOMv1p0" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" schemaVersion="1.02.020" xsi:schemaLocation="http://ns.nsdl.org/nsdl_dc_v1.02/ http://ns.nsdl.org/schemas/nsdl_dc/nsdl_dc_v1.02.xsd">
		<!-- nsdl_dc specific fields -->
		<dc:identifier xsi:type="dct:ISBN">ISBN</dc:identifier>
		<!-- comment -->
		</nsdl_dc:nsdl_dc>
EOD;
		$doc_1->keys = array("Test","");
		$doc_1->tos = LRConfig::SUBMISSION_TOS_URL;
		$doc_1->payload_placement = "inline";
		$doc_1->resource_data_type = "metadata";
		$doc_1->payload_schema = array("hashtags"=>"describing","resource","format");
		$doc_1->active = true;
		$doc_1->resource_locator = "http://www.learningregistry.org";
		$doc_1->identity = array(
			"curator"=>"John Doe",
			"owner"=>"John Doe",
			"submitter"=>"John Doe",
			"signer"=>LRConfig::GPG_OWNER, // TODO: GPG Public key store provides this?
			"submitter_type"=>"agent"
		);
		LR::init('publish');
		// Overloaded static calls only work in PHP 5.3+.  Call the service directly to add document
		LR::getService()->addDocument($doc_1);
		$e = LR::execute();
		if($e == true)
		{
		    print_r(LR::getResponse());
		} else print_r(LR::getErrors());
		$this->assertFalse(TRUE);
	}
}

LRPublishTest::testPublish();