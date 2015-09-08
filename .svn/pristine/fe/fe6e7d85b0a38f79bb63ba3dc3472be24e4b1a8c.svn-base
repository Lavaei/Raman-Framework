<?php
namespace Raman;

use Raman\Form\Decorator\Raman_Form_Decorator_Responsive;

/**
 * Raman Zend_Form
 *
 * @author Mostafa Lavaei <lavaei@ramansoft.co>
 * @version 1.0
 */

class Raman_Form extends \Zend_Form
{
	protected $_multiPart = 'enctype= multipart/form-data';
	
	/**
	 *
	 * @param array $initData
	 *        	The initial value of inputs
	 */
	public function __construct (array $initData = array())
	{
		$defaultDecorators = array(
				'ViewHelper',
				new Raman_Form_Decorator_Responsive(array(
						'tag' => 'div'
				))
		);
		$fileDecorators = array(
				'File',
				new Raman_Form_Decorator_Responsive(array(
						'tag' => 'div'
				))
		);
	
		$ses 	= new \Zend_Session_Namespace('csrf');
		$token 	= new \Zend_Form_Element_Hidden('token');
		$token->setValue($ses->token);
	
		$this->setElementDecorators($defaultDecorators);
	
		$this->setAttrib('class', 'form-horizontal');
	
		$this->setMethod('POST');
	
		$this->addElement($token);
	
		$this->init($initData);
	
		$elements = $this->getElements();
		
		foreach($this->getElements() as $element)
		{
			if(($element instanceof \Raman\Form\Raman_Form_Element) == false)
			{
				if($element instanceof \Zend_Form_Element_File)
				{
					$element->setDecorators($fileDecorators);
				}
				elseif($element instanceof \Zend_Form_Element_Captcha)
				{
					$element->setDecorators($defaultDecorators);
					$element->removeDecorator('viewhelper');
				}
				else
				{
					$element->setDecorators($defaultDecorators);
				}
			}
		}
	
		$this->loadDefaultDecorators();
	}
	
	public function init ($initData = array())
	{
	}
	
	public function isValid ($data)
	{
		$ses = new \Zend_Session_Namespace('csrf');
	
		if($data['token'] != $ses->token)
			return false;
	
		return parent::isValid($data);
	}
	
	public function getNoneSubmitElements()
	{
		$elements = array();
		
		foreach ($this->getElements() as $element)
		{
			if($element instanceof \Zend_Form_Element_Submit == false)
				$elements[] = $element;
		}
		
		return $elements;
	}
}