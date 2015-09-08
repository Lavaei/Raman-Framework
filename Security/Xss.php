<?php
namespace Raman\Security;

/**
 * Raman Auto XSS Protector
 * 
 * @author Mostafa Lavaei <lavaei@ramansoft.co>
 * @version 1.0
 */

class Raman_Security_Xss
{
	/**
	 * @var \Zend_Application_Bootstrap_Bootstrap
	 */
	protected $bootstrapObj;
	protected $view;
	
	/**
	 * @param \Zend_Application_Bootstrap_Bootstrap $bootstrapObj
	 */
	public function __construct($bootstrapObj)
	{
		$this->bootstrapObj = $bootstrapObj;
		$this->view 		= \Zend_Registry::get('view');
		
		$this->secureParams();
	}

	/**
	 * Method to urlencode ALL params found in the GET and POST
	 * variables.(Prevent From XSS Attacks)
	 * Does not apply to any of the POST variables for controllers inside the
	 * $exception_controller_get_list array.
	 *
	 * @return void
	 */
	
	protected function secureParams()
	{		
		 
		$this->bootstrapObj->bootstrap('frontController');
		$front = $this->bootstrapObj->getResource('frontController');
		$front->setRequest(new \Zend_Controller_Request_Http());
		
		$request = $front->getRequest();
		
		\Zend_Controller_Front::getInstance()->getRouter()->route($request);
		$current_controller = $request->getControllerName();
		$exception_controller_get_list = array(
				'controllerone'
		);
		
		$getParams = $request->getParams();
		
		foreach ($getParams as $key => $value)
		{
			$value = $this->escape($value);
		
			$request->setParam($key, $value);
		}
		
		if (! in_array($current_controller, $exception_controller_get_list))
		{
			$postParams = $request->getPost();
			$safePostParams = array();
		
			foreach ($postParams as $key => $value)
			{
				$value = $this->escape($value);
		
				$safePostParams[$key] = $value;
			}
		
			$request->setPost($safePostParams);
		}
	}
	
	/**
	 * Modified Zend View Escape To Accept Arrays
	 * @param mixed $unescaped
	 * @return mixed
	 */
	public function escape($unescaped)
    {
    	if(is_array($unescaped))
    	{
    		$return = array();
        		
    		foreach ($unescaped as $val)
        		$return[] = $this->escape($val);
        		
        	return $return;
        }
        else 
        {
        	return $this->view->escape($unescaped);
        }
    }
}