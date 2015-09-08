<?php
namespace Raman;

/**
 * @author Mostafa Lavaei <lavaei@ramansoft.co>
 * @version 1.0
 */
class Raman_Translate extends \Zend_Translate
{	
	
	public function __construct($options = array())
	{
		parent::__construct($options);
		
		$this->init();
	}
	
	public function init()
	{
        
	}

}