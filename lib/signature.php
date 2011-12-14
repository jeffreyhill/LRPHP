<?php
require_once 'Crypt/GPG.php';
require_once LRDIR.DS.'lib'.DS.'bencode.php';

class LRSignature
{
	static function sign_file($filedata)
	{
		$gpg = new Crypt_GPG();
		$gpg->addSignKey('wegrata@gmail.com');
		$signature = $gpg->sign($filedata, Crypt_GPG::SIGN_MODE_CLEAR);
		return $signature;
	}
	
	static function import_key($key_url)
	{
		$gpg = new Crypt_GPG();
		$gpg->importKeyFile($key_url);
	}
	
	static function normalize_data($data)
	{
		if (is_null($data)){
			return "null";
		} else if (is_numeric($data)){
			return strval($data);
		} else if (is_bool($data)){ 
			return $data ? "true" : "false";
		}else if(is_array($data)){
			foreach($data as $subKey => $subValue){
				$data[$subKey] = normalize_data($subValue);
			}
		}		
		return $data;
	}
	
	static function format_data_to_sign(LRDocument $document){
	    
		unset($document['digital_signature']);
	
		unset($document['_id']);
		unset($document['_rev']);
	
		unset($document['doc_ID']);
		unset($document['publishing_node']);
		unset($document['update_timestamp']);
		unset($document['node_timestamp']);
		unset($document['create_timestamp']);
	
		$document = self::normalize_data($document);
		$encoder = new bencoding();
		$data = utf8_encode($encoder->encode($document));
		$hash = hash('SHA256',$data);
		return $hash;
	}
	
	static function verify_file($signature)
	{
		$gpg = new Crypt_GPG();
		$results = $gpg->verify($signature);
		return $results;
	}
	
	static function read_file($filename)
	{
		$handle = fopen($filename,'r');
		$data = fread($handle,filesize($filename));
		fclose($handle);
		return $data;
	}
	
	function write_file($filename,$data)
	{
		$handle = fopen($filename,'w');
		fwrite($handle,$data);
		fclose($handle);
	}
	
	function get_hash_from_signature($signature)
	{
		$parts = preg_split('[\r|\n]',$signature);	
		return $parts[3];
	}
	
	function test_verify(LRDocument $document)
	{
		self::import_key($document['digital_signature']['key_location'][0]);
		$signature = $document['digital_signature']['signature'];
		$testHash = self::get_hash_from_signature($signature);
		$signData = self::format_data_to_sign($document);
		if($signData == $testHash) {
			$resultList = self::verify_file($signature);
			$result = $resultList[0];
			if($result->isValid()){
				return true;
			}
		}
		return false;
	}
	
	function test_signing(LRDocument $document)
	{
		$hash = self::format_data_to_sign($document);
		$signature = self::sign_file($hash);
		$document['digital_signature'] = array(
			'key_location' => array('http://12.109.40.15/resource_data/key/key.asc'),
			'signature' => $signature,
			'key_owner' => 'wegrata@gmail.com',
			'signing_method' => 'LR-PGP.1.0'
		);
		return $document;
	}

}

	$testFile = '2011-02-28Metadata10.json';
	$signedFile = 'signedOutput.json';
	test_signing($testFile,$signedFile);
	test_verify($signedFile);
?>