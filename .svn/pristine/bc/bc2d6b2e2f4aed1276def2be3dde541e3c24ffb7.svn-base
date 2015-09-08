<?php
namespace Raman\Form\Element;

/**
 * Cellphone Form Element with filters,validators,css,javascripts and all it needs
 *
 * @author Mostafa Lavaei <lavaei@ramansoft.co>
 * @version 1.0
 */
class Raman_Form_Element_Cellphone extends \Zend_Form_Element_Text
{
	public function __construct($spec, $options)
	{
		parent::__construct($spec, $options);
	
		if(isset($options['pattern']))
			$pattern 	= $options['pattern'];
		else
			$pattern 	= "^+[0-9]{1,2}-[0-9]{3}-[0-9]{3}-[0-9]{4}$";
		
		$this->setAttrib('type', 'tel')
		->setAttrib('pattern', $pattern)
		->addValidator(new Zend_Validate_Regex("/$pattern/")); //+98-919-924-9196
	}
}