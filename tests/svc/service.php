<?php
// @package LR-PHP
// @copyright 2011 Jeffrey Hill
// @license Apache 2.0 License http://www.apache.org/licenses/LICENSE-2.0.html
require_once('../lr.php');
require_once(LRDIR.DS.'svc'.DS.'service.php');

class LRServiceTest extends PHPUnit_Framework_TestCase 
{
  
  public function testVerb() 
  {
    $lrService = new LRService;
    $lrService->setVerb("default");
    $result = $lrService->getVerb();
    $this->assertEquals("default", $result);
  }
}
