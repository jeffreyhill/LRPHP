<?php
// @package LR-PHP
// @copyright 2011 Jeffrey Hill
// @license Apache 2.0 License http://www.apache.org/licenses/LICENSE-2.0.html
defined('LREXEC') or die();

class LRUtility {
    
    public static function _($t) // Identity
    {
        return $t;
    }
    
    public static function _boolean($t)
    {
        return $t ? 'true' : 'false';
    }
    
    public static function _date($t)
    {
        return date('c',strtotime($t));
    }
    
    public static function _datetime($t)
    {
        return date('Y-m-d',strtotime($t));
    }
    
    public static function _int($t)
    {
        return intval($t);
    }
    
    public static function _string($t)
    {
        return (string) $t;
    }
    
}
