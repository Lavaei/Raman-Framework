<?php
namespace Raman\Security;

/**
 * Raman Auto CSRF Protector
 * Designed For Using in Bootstrap.php
 * 
 * @author Mostafa Lavaei <lavaei@ramansoft.co>
 * @version 1.0
 */

class Raman_Security_Csrf
{
	protected $ses;
	
	public function __construct()
	{
		$this->ses 	= new \Zend_Session_Namespace('csrf');
	
		$this->setToken();
	}
	
	/**
	 * This method use to auto-generate Zend_Form_Element_Csrf in Raman_Forms_*
	 */
	protected function setToken ()
	{
		if (!$this->ses->token)
		{
			$this->ses->setExpirationSeconds(86400);
	
			$this->ses->token = md5(rand(0, 1000000));
		}
	}
}