<?php
namespace Raman\Form\Element;

/**
 * Home Phone Form Element with filters,validators,css,javascripts and all it needs
 *
 * @author Mostafa Lavaei <lavaei@ramansoft.co>
 * @version 1.0
 */
class Raman_Form_Element_HomePhone extends \Zend_Form_Element_Text
{
	public function __construct($spec, $options)
	{
		parent::__construct($spec, $options);
	
		if(isset($options['pattern']))
			$pattern 	= $options['pattern'];
		else
			$pattern 	= "^0[0-9]{2,}-[0-9]{8}$";
		
		$this->setAttrib('type', 'tel')
		->setAttrib('pattern', $pattern)
		->addValidator(new Zend_Validate_Regex("/$pattern/")); //021-12345678
	}
}