<?php
// @package LR-PHP
// @copyright 2011 Jeffrey Hill
// @license Apache 2.0 License http://www.apache.org/licenses/LICENSE-2.0.html
require_once('../lr.php');
LR::init('slices');
LR::debug();
LR::setArgs(array(
    'any_tags'=>'paradata',
    'full_docs'=>false
));
$e = LR::execute();
if($e == true)
{
    $json = TidyJSON::tidy(LR::getResponse());
    print_r(json_decode($json));
}
print_r(LR::getErrors());
?>