<?php
namespace Raman\Form;

/** 
 * This class is parent of all Raman Form Elements
 *
 * @author Mostafa Lavaei <lavaei@ramansoft.co>
 * @version 1.0
 */
class Raman_Form_Element extends \Zend_Form_Element
{	
	public function init()
	{					
		$this->addPrefixPath('Raman_Form_Decorator', 	'Raman/Form/Decorator'	, self::DECORATOR);
		$this->addPrefixPath('Raman_Validate', 			'Raman/Validate'		, self::VALIDATE);
		$this->addPrefixPath('Raman_Filter', 			'Raman/Filter'			, self::FILTER);						

	}
}