<?php
namespace Raman\Form\Decorator;

/**
 * Responsive Decorator.
 *
 * @author Mostafa Lavaei <lavaei@ramansoft.co>
 * @version 1.0
 */

class Raman_Form_Decorator_Responsive extends \Zend_Form_Decorator_Abstract
{
	public function buildLabel ()
	{
		$element = $this->getElement();
		$inputName = $element->getName();
		
		if(strIpos($element->id, 'submit') !== false)
			return null;
		
		$label = $element->getLabel();
		
		if(($translator = $element->getTranslator()) == true)
		{
			$label = $translator->translate($label);
		}
		
		if($element->isRequired())
		{
			$label .= '<span class="req">*</span>';
		}
		
		return "<label for='$inputName' class='control-label col-lg-3 col-md-3 col-sm-3 col-xs-12' >$label</label>";
	}

	public function buildErrors ()
	{
		$element = $this->getElement();
		$messages = $element->getMessages();
		if(empty($messages))
			return '';
		return "<div class='errors'>{$element->getView()->formErrors($messages)}</div>";
	}

	public function buildDescription ()
	{
		$element = $this->getElement();
		$desc = $element->getDescription();
		if(empty($desc))
		{
			return '';
		}
		return "<div class='col-lg-4 col-md-3 col-sm-2 hidden-xs form-description'> <span class='visible-lg-block'><i><small>$desc</small></i></span> <span class='hidden-lg'><span title='$desc' class='glyphicon glyphicon-question-sign'></span> </div>";
	}

	public function render ($content)
	{		
		$element = $this->getElement();
		
		$view 		= $element->getView();		
		
		if(!$element instanceof \Zend_Form_Element)
			return $content;
		
		if($view === null)
			return $content;
		
		
		$orginContent = $content;
		$content = "<div class='col-lg-5 col-md-6 col-sm-7 col-xs-12'>$content</div>";
		$label = $this->buildLabel();
		$errors = $this->buildErrors();
		$desc = $this->buildDescription();
		
		if($element instanceof \Zend_Form_Element_Multi)
		{
			$content = str_replace('id=', "class='form-control' id=", $content);
		}
		elseif($element instanceof \Zend_Form_Element_Submit)
		{
			$style = $element->getAttrib('style');
			
			$content = str_replace('id=', "style='$style' id=", $content);
			$result = "<div class='form-group'><div class='col-lg-offset-3 col-md-offset-3 col-sm-offset-4'>$content</div></div>\n";
		}
		else 
			if($element instanceof \Zend_Form_Element_File)
			{
				$title = $element->getAttrib('title');
				
				if(!$title)
					$title = 'Browse';
				
				$classes = $element->getAttrib('class');
				
				$content = str_replace('id=', "class='file-inputs $classes' title='$title' id=", $content);
			}
			else 
				if($element instanceof \Zend_Form_Element_Checkbox)
				{
					$content = str_replace('id=', "class='checkbox' id=", $content);
				}
				elseif($element instanceof \Zend_Form_Element_Hidden)
				{
					$result = "<div style='display:none'>$content</div>";
				}
				elseif($element instanceof \Zend_Form_Element_Captcha)
				{
					$name = $element->getName();
					$content = str_replace("img", "img style='margin:0 auto; margin-bottom:14px; display:block; '", $content);
					$content = str_replace("id=\"$name-input\"", "class='form-control' id=\"$name-input\"", $content);
				}
				elseif($element instanceof \Zend_Form_Element_TreeView)
				{
					
				}
				elseif($element instanceof \Zend_Form_Element_Textarea)
				{
					$content = "<div class='col-xs-9'>$orginContent</div>";
					$content = str_replace('id=', "class='form-control' id=", $content);
				}
				else if($element instanceof Raman_Form_Element_HtmlTag)
				{
					return $orginContent;
				}
				else
				{
					$content = str_replace('id=', "class='form-control' id=", $content);
				}
				
		
		if(!isset($result))
			$result = "\t\t\t\t\t\t<div class='form-group'>$label$content$desc</div>\n";
		
		return $result;
	}
}
?>