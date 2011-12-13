<?php
// @package LR-PHP
// @copyright 2011 Jeffrey Hill
// @license Apache 2.0 License http://www.apache.org/licenses/LICENSE-2.0.html
require_once('../../lr.php');

class LRObtainTest extends PHPUnit_Framework_TestCase
{
    public function getRecord()
    {
      //TODO:  Convert this to an actual PHPUnitTest
      LR::init('obtain');
      LR::setArgs(array(
          'by_resource_ID'=>true,
          'request_IDs'=>array('b3398a58f0ff417bb3e56e20e7edc787')
      ));
      $e = LR::execute();
      if($e == true)
      {
          print_r(LR::getResponse());
      } else print_r(LR::getErrors());
    }
}
?>
