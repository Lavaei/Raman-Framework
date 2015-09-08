<?php
namespace Raman\Config;

/**
 * Set Consts
 * @author Mostafa Lavaei <lavaei@ramansoft.co>
 * @version 1.0
 */
class Raman_Config_Consts
{
	/**
	 * Add or change a const
	 * @param string $name
	 * @param $value
	 */
	public static function add($name, $value)
	{
		$instance = \Zend_Registry::get('Raman_Config_Consts_Instance');
		$instance[$name] = $value;
		\Zend_Registry::set('Raman_Config_Consts_Instance', $instance);
	}
	
	/**
	 * Get a const value
	 * @param string $name
	 * @return The const's value
	 */
	public static function get($name)
	{
		$instance = \Zend_Registry::get('Raman_Config_Consts_Instance');
		
		return $instance[$name];
	}
}