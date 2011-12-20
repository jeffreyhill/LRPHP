<?php
// @package LR-PHP
// @copyright 2011 Jeffrey Hill
// @license Apache 2.0 License http://www.apache.org/licenses/LICENSE-2.0.html

if(!defined('DS')) define('DS', '/');
define('LREXEC',1);
define('LRDIR',dirname(__FILE__));

class LR
{
    public static $debug = false;
    
    protected static $ch;
    protected static $errors = array();
    protected static $service;
    protected static $request;
    protected static $response;
    
    private function __construct() {}
    private function __clone() {}
    
    /**
     * Debugging
     * @return void  
     */
    public static function debug()
    {
        self::$debug = true;
    }
    
    /**
     * Retrieves error stack
     * @return array
     */
    public static function getErrors()
    {
        return self::$errors;
    }
    
    /**
     * Private function used to send requests to LR Node using cURL
     * @param none
     * @return void  
     */
    public static function execute()
    {
        // Initialize cURL handler
        self::$ch = curl_init();
        $url = LRConfig::getURL().DS.self::getServiceName();
        if(self::getAction() == "POST")
        {
            if(self::$service->getVerb() != 'default')
            {
                $url .= DS.self::$service->getVerb();
            }
            $args = self::getArgs();
            curl_setopt (self::$ch, CURLOPT_POST, true);
            curl_setopt (self::$ch, CURLOPT_POSTFIELDS, $args);
            curl_setopt (self::$ch, CURLOPT_HTTPHEADER, array("Content-type: application/json","Content-length:".strlen($args)));
            if(self::$debug) echo $args;
        }
        else if(self::getAction() == "GET")
        {
            // TODO: str_replace not necessary in PHP 5.3+
            $url .= "?".str_replace('+','%20',http_build_query(self::getArgs()));
        } else { // Other HTTP methods are currently not implemented/allowed
            self::setError('HTTP Method '.self::getAction().' not permitted');
            return false;
        }
        if(self::$debug)  echo 'URL:'.$url;
        curl_setopt (self::$ch, CURLOPT_URL, $url);
        curl_setopt (self::$ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt (self::$ch, CURLOPT_TIMEOUT, 1000);
        self::$service->data = curl_exec(self::$ch);
        if(self::$service->data === false)
        {
            self::setError('cURL Error<br /><br />'.curl_error(self::$ch));
            return false;
        }
        return true;
    }
    
    /**
     * Gets the default action the service calls for (GET/POST)
     * @return array
    */
    private static function getAction()
    {
        return self::$service->action;
    }
    
    /**
     * Gets the current array of arguments prepared for the currently loaded LR Service
     * @return array
    */
    public static function getArgs()
    {
        return self::$service->getArgs();
    }
    
    /**
     * Gets the response from LR Node
     * @return string json
    */
    public static function getResponse()
    {
        if(!self::$service->data)
        {
            self::setError('LR response not found');
        }
        return self::$service->data;
    }

	/*
	 * Temporary function to get a service (PHP 5.x)
	 * 
	*/
	public static function getService()
	{
		return self::$service;
	}

    /**
     * Gets the LR object name currently loaded
     * @return string
    */
    public static function getServiceName()
    {
        if(!is_a(self::$service,'LRService'))
        {
            self::setError('Service not found');
        }
        return strtolower(substr(get_class(self::$service),2));
    }
    
    /**
     * Initializes a request for LR
     * @param string service type
     * @return true on success, false on failure
    */
    public static function init($service)
    {
        try {
            require_once('config.php');
            self::loadService($service);
        } catch (Exception $e) {
            $self::setError($e->getMessage());
            return false;
        }
        return true;
    }
    
    /**
     * Loads an LR service representing an object type (i.e. node, document)
     * @return void
    ar/*/
    private static function loadService($service)
    {
        // Import LR service and base
        require_once('svc'.DS.'service.php');
        require_once('svc'.DS.$service.'.php');
        // TODO: Static calls for services in PHP 5.3
        $service = 'LR'.ucfirst($service);
        self::$service = new $service;
    }
    
    /**
     * Set arguments for cURL request, stored in the service instance
     * @param array $args
     * @return void
     */
    public static function setArgs($args)
    {
        self::$service->setArgs($args);
    }
    
    /**
     * Appends an error message
     * @param string $error
     * @return void
     */
    private static function setError($error)
    {
        self::$errors[] = $error;
    }
    
    public static function setVerb($verb)
    {
        if(!self::$service->setVerb($verb))
            self::setError('Verb not valid');
    }
    /**
     * Unset current service arguments.
     * @return void
     */
    public static function unsetArgs()
    {
        unset(self::$service->args);
    }
    
}
