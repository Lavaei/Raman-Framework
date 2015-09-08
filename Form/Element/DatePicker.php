<?php
namespace Raman\Form\Element;

use \Raman\Form\Raman_Form_Element;

/**
 * Date Picker Form Element with filters,validators,css,javascripts and all it needs
 *
 * @author Mostafa Lavaei <lavaei@ramansoft.co>
 * @version 1.0
 */
class Raman_Form_Element_DatePicker extends Raman_Form_Element
{
	
	const DATE_PICKER_MODE_COMBOBOX 	= 0;
	const DATE_PICKER_MODE_CALENDAR 	= 1;
	
	/**
	 * List of days
	 * @var array
	 */
	const DATE_PICKER_DAYS 				= array(
			'sun' => 1,
			'mon' => 2,
			'tue' => 3,
			'wed' => 4,
			'thu' => 5,
			'fri' => 6,
			'sat' => 7
	);
	
	/**
	 * List of months
	 * @var array
	 */
	const DATE_PICKER_MONTH 			= array(
			'jan' 	=> 1,
			'feb' 	=> 2,
			'mar' 	=> 3,
			'apr' 	=> 4,
			'may' 	=> 5,
			'jun' 	=> 6,
			'jul' 	=> 7,
			'aug' 	=> 8,
			'sep' 	=> 9,
			'oct' 	=> 10,
			'nov' 	=> 11,
			'dec' 	=> 12
	);
	
	public $helper = 'formDatePicker';
	
	public function __construct()
	{

	}
	
	/**
	 * Set How DatePicker Should Render (Combobox, Calendar, etc)
	 * @param int $input_type. you can call input types with const which introduced with DATE_PICKER_MODE_ prefix in this element
	 * @return Raman_Form_Element_DatePicker
	 */
	public function setInput($input_type)
	{
		return $this;
	}
	
	/**
	 * Set Available Years
	 * @param array $options
	 * @return Raman_Form_Element_DatePicker
	 * @example setYears(array( <br/>
	 * 		'start' 	=> 1990/10/20, 							//<b><i>the days before 1990/10/20 will disable</i></b> 	<br/>
	 * 		'start' 	=> time() - 3600*24, 					//<b><i>the days before yesterday will disable</i></b> 		<br/>
	 * 		'end' 		=> 2020/10/20, 							//<b><i>the days after 2020/10/20 will disable</i></b> 		<br/>
	 * 		'start' 	=> time() + 3600*24*7, 					//<b><i>the days after 7 days later will disable</i></b>	<br/>
	 * 		'except' 	=> array(2000/1/1, 2001/1/1, 2002/1/1), //<b><i>these dates will disable</i></b>					<br/>
	 * 		'except' 	=> array(2000, 2001, 2002), 			//<b><i>these years will disable</i></b>					<br/>
	 * 		'except' 	=> array('thu', 'fri'),					//<b><i>All Thusdays and Fridays will disable</i></b> 		<br/>
	 * 		'except' 	=> array('jan') 						//<b><i>All Januaries will disable</i></b> 					<br/>
	 * ));
	 */
	public function setAvailableDays($options)
	{
		/*
		 * define variable
		 */
		$finalStart 	= 0;
		$finalEnd 		= time();
		$finalExcept 	= array();
		
		/*
		 * get options
		 */
		$optStart 			= $options['start'];
		$optEnd 			= $options['stop'];
		$optExcept 			= $options['except'];
		
		/*
		 * define patterns
		 */
		$datePattern 		= "@^[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}$@";
		$timestampPattern 	= "@^[0-9]+$@";

		
		/*
		 * #####################
		 * process start option
		 * #####################
		 */					
		if(preg_match($datePattern, $optStart))
		{
			/*
			 * $optStart is in date format, ex. 1990/10/20
			 */
			
			$finalStart 	= strtotime($optStart);
		}
		else if(preg_match($timestampPattern, $optStart))
		{
			/*
			 * $optStart is in Unix Time Stamp format, ex. 123456789
			 */
			$finalStart 	= $optStart;
		}
		else
		{
			/*
			 * $optStart has an unknown format
			 */
			
			throw new \Exception('"start" has an unknown format');
		}
						
		
		
		
		/* 
		 * #####################
		 * process end option
		 * #####################
		 */
		if(preg_match($datePattern, $optEnd))
		{
			/*
			 * $optEnd is in date format, ex. 2020/10/20
			 */
		
			$finalEnd 	= strtotime($optEnd);
		}
		else if(preg_match($timestampPattern, $optEnd))
		{
			/*
			 * $optEnd is in Unix Time Stamp format, ex. 123456789
			 */
			$finalEnd 	= $optEnd;
		}
		else
		{
			/*
			 * $optEnd has an unknown format
			 */
		
			throw new \Exception('"end" has an unknown format');
		}
		
		
		
		
		/* 
		 * #####################
		 * process except option
		 * #####################
		 */
		
		foreach ($optExcept as $opt)
		{
			if(preg_match($datePattern, $opt))
			{
				/*
				 * $opt is in date format, ex. 2020/10/20
				 */
					
				$finalExcept[] 	= strtotime($opt);
			}
			else if(is_numeric($opt))
			{
				/*
				 * $opt is a year!!, ex. 2010
				 */
				$finalExcept[] 	= $opt;
			}
			elseif (in_array($opt, self::DATE_PICKER_MONTH))
			{
				/*
				 * $opt is a month!!, ex. jun
				 */
				$monthsList 	= self::DATE_PICKER_MONTH;
				$finalExcept[] 	= $monthsList[$opt];
			}
			elseif (in_array($opt, self::DATE_PICKER_DAYS))
			{
				/*
				 * $opt is a day!!, ex. sat
				 */
				$daysList 		= self::DATE_PICKER_DAYS;
				$finalExcept[] 	= $daysList[$opt];
			}
			else
			{
				/*
				 * $optEnd has an unknown format
				 */					
				throw new \Exception('"except" has an unknown format');
			}
		}
		
		return $this;
	}
	
	/**
	 * Set Selected Date (Default Value)
	 * @param int|string $date in Time String or Unix Time Stamp fromat
	 * @return Raman_Form_Element_DatePicker
	 */
	public function setSelectedDate($date)
	{
		/*
		 * define patterns
		 */
		$datePattern 		= "@^[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}$@";
		$timestampPattern 	= "@^[0-9]+$@";
		
		/*
		 * convert input to standard format (Unix Time Stamp)
		 */
		if(preg_match($datePattern, $date))
		{
			/*
			 * $date is like 2020/10/20
			 */
				
			$date 	= strtotime($date);
		}
		elseif(preg_match($timestampPattern, $date))
		{
			/*
			 * $date is an Unix Time Stamp
			 */			
		}
		else 
		{
			/*
			 * $date is not in any supported formats
			 */
			
			throw new \Exception('Selected Date is not in any supported formats');
		}
		
		
		return $this;
	}
}
?>