<?php
/**
 * Created by Serhii Dudik.
 * User: dudman
 * Date: 11.02.15
 * E-mail: duda902@gmail.com
 */

class Registry
{
	private static $_instance = null;
	private $_data = array();

	public static function getInstance()
	{
		if (self::$_instance) {
			return self::$_instance;
		}
		return (self::$_instance = new self());
	}

	public function  __set($name,  $value)
	{
		$this->_data[$name] = $value;
	}
	public function  __get($name)
	{
		return (isset ($this->_data[$name]) ? $this->_data[$name] : null);
	}

}
/**
 * Usage
 */
Registry::getInstance()->aVar = 'aValue';
var_dump(Registry::getInstance()->aVar);