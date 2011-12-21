<?php
// @package LR-PHP
// @copyright 2011 Jeffrey Hill
// @license Apache 2.0 License http://www.apache.org/licenses/LICENSE-2.0.html
require_once('../../lr.php');

class LRObtainTest extends PHPUnit_Framework_TestCase
{
  const START_DATE = '2011-11-01';
  const END_DATE = '2011-11-05';
  
  public function testGetRecord()
  {
    LR::init('slice');
    //LR::debug();
    LR::setArgs(array(
      'from'=>self::START_DATE,
      'until'=>self::END_DATE,
      'ids_only'=>true
     ));
    $e = LR::execute();
    $this->assertTrue($e);

    if($e == true)
    {
      $results = LR::getResponse();
      $results = json_decode($results);
      $errors = LR::getErrors();

      $this->assertNotEmpty($results);
      $this->assertEmpty($errors);
      $this->assertGreaterThan(0,count($results->documents));
      
      if (count($results->documents) > 0) 
      {
        $doc_ID = $results->documents[0]->doc_ID;
        
        LR::init('obtain');
        LR::setArgs(array(
            'by_doc_ID'=>true,
            'request_ID'=>$doc_ID
        ));
        $e = LR::execute();
        
        $this->assertTrue($e);
        if($e == true)
        {
          $json = LR::getResponse();
          $results = json_decode($json);
          
          if (count($results->documents) > 0)
          {
              $this->assertObjectHasAttribute('doc_ID', $results->documents[0]);
              $this->assertObjectHasAttribute('resource_data', $results->documents[0]->document[0]);
          }
        }
      }
    }
  }
}
