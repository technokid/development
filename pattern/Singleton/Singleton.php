<?php
/**
 * User: Dudman
*/

class Singleton {
	protected static $instance;

	public static function getInstance()
	{
		if ( !isset(self::$instance) ) {
			$class = __CLASS__;
			self::$instance = new $class();
			//echo "<p>Первай запуск</p>";
		} else {
			//echo "<p>уже запущен</p>";
		}

		return self::$instance;
	}

	private function __construct() { }  // Защита от создания через new Singleton
	private function __clone()     { }  // Защита от создания через клонирование
	private function __wakeup()    { }  // Защита от создания через unserialize
}