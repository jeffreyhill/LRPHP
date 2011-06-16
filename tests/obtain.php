<?php
require_once('../lr.php');
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
?>