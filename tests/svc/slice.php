<?php
// @package LR-PHP
// @copyright 2011 Jeffrey Hill
// @license Apache 2.0 License http://www.apache.org/licenses/LICENSE-2.0.html
require_once(dirname(__FILE__).'/../../lr.php');

class LRSlicesTest extends PHPUnit_Framework_TestCase 
{
  
  const START_DATE = '2011-11-01';
  const END_DATE = '2011-11-05';
  
  public function testSliceDateRange() {
    LR::init('slice');
    //LR::debug();
    LR::setArgs(array(
      'from'=>self::START_DATE,
      'until'=>self::END_DATE
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
      $this->assertGreaterThan(0,$results->keyCount);
      $this->assertGreaterThan(0,count($results->documents));
      
      if (count($results->documents) > 0) 
      {
          $this->assertObjectHasAttribute('doc_ID', $results->documents[0]);
          $this->assertObjectHasAttribute('resource_data_description', $results->documents[0]);
      }
           
      // DEBUG Code, uncomment as needed.
      //$json = TidyJSON::tidy($results);
      //print_r(json_decode($json));
      //$fp = fopen('/tmp/results.json', 'w');
      //fwrite($fp, $json);
      //fclose($fp);
    }
  }
  
    public function testSliceIdsOnly() {
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
        $this->assertGreaterThan(0,$results->keyCount);
        $this->assertGreaterThan(0,count($results->documents));

        if (count($results->documents) > 0) 
        {
          $this->assertNotEmpty($results->documents[0]->doc_ID);
          //$this->assertEmpty($results->documents[0]->resource_data_description);
          $this->assertObjectHasAttribute('doc_ID', $results->documents[0]);
          $this->assertObjectNotHasAttribute('resource_data_description', $results->documents[0]);
        }
     }
   }
}
