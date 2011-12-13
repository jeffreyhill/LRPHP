<?php
// @package LR-PHP
// @copyright 2011 Jeffrey Hill
// @license Apache 2.0 License http://www.apache.org/licenses/LICENSE-2.0.html
require_once('../lr.php');
require_once('../utility.php');

class LRUtilityTest extends PHPUnit_Framework_TestCase 
{
  public function testBoolean() 
  {
    $test = 'false';
    $result = LRUtility::_boolean(FALSE);
    $this->assertEquals($test, $result);
    
    $test = 'true';
    $result = LRUtility::_boolean(TRUE);
    $this->assertEquals($test, $result);
  }
  
  public function testDate() 
  {
    $test = '2011-12-01';
    $result = LRUtility::_date('01-12-2011');
    $this->assertEquals($test, $result);
  }
  
  public function testDateTime() 
  {
    $test = '2011-12-01T00:00:00-05:00';
    $result = LRUtility::_datetime('01-12-2011');
    $this->assertEquals($test, $result);
  }
  
  public function testInt() 
  {
    $test = '12345';
    $result = LRUtility::_int(12345);
    $this->assertEquals($test, $result);
  }
  
  public function testString() 
  {
    $test = 'this is a string';
    $result = LRUtility::_string('this is a string');
    $this->assertEquals($test, $result);
  }
  
}

?>
