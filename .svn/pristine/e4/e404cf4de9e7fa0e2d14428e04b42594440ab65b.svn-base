<?php

class Raman_View_Helper_FormDatePicker extends \Zend_View_Helper_FormText
{
    public function formDatePicker($name, $value = false, $attribs = null)
    {
        //Set path
        $jsPath             = ROOT_URL . 'libraries/js';
        $jqueryDirPath      = ROOT_URL . 'libraries/jquery';
        $jqueryUIDirPath    = ROOT_URL . 'libraries/jqueryui';
        
        //load javascripts                
        $oldJquery                  = "<script src='$jqueryDirPath/jquery-1.8.2.js'></script>";
        $jqueryUICore               = "<script src='$jqueryUIDirPath/jquery.ui.core.js'></script>";
        $jqueryUIDatePicker         = "<script src='$jqueryUIDirPath/jquery.ui.datepicker-cc.js'></script>";          
        $calendar                   = "<script src='$jsPath/calendar.js'></script>";
        $jqueryUIDatePickerShamsi   = "<script src='$jqueryUIDirPath/jquery.ui.datepicker-cc-fa.js'></script>";

        //load styles
        $jqueryUICss        = "<link rel='stylesheet' href='$jqueryUIDirPath/jquery-ui-1.8.14.css' />";
        
        
        //create Html tag
        $textInputId        = $name . '_' . rand(0, 1000000);//generate random id
        $attribs['id']      = $textInputId;//set generated id
        $attribs['style']   .= "text-align:center";//set generated id

        $textInputHtml  = $this->formText($name, $value, $attribs);//get output of FormText helper        
        
        //execute scripts
        $executeScript      = "
                <script>
                    $(document).ready(function(){
                        $('#$textInputId').datepicker();
                    });
                </script>                
        ";               

        //assemble all parts
        $xhtml  = $oldJquery . $jqueryUICore .  $jqueryUIDatePicker . $calendar . $jqueryUIDatePickerShamsi . $jqueryUICss . $textInputHtml . $executeScript;
        

        //return assembled parts
        return $xhtml;
    }
}