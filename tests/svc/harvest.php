<?php
// @package LR-PHP
// @copyright 2011 Jeffrey Hill
// @license Apache 2.0 License http://www.apache.org/licenses/LICENSE-2.0.html
require_once('../../lr.php');

class LRHarvestTest extends PHPUnit_Framework_TestCase 
{
  public function harvest() {
  //TODO:  Convert this to an actual PHPUnitTest
    
    LR::init('harvest');
    LR::setVerb('getrecord');
    LR::setArgs(array(
        'request_ID'=>'b3398a58f0ff417bb3e56e20e7edc787'
    ));
    $e = LR::execute("POST");
    if($e == true) {
      print_r(LR::getResponse());
    } 
    else {
      print_r(LR::getErrors());
    }

    LR::init('harvest');
    LR::setVerb('listrecords');
    LR::setArgs(array(
        'from'=>'2009-01-01',
        'until'=>'2011-06-01'
    ));
    $e = LR::execute("POST");
    print_r(LR::getResponse());
  }
}
?>
