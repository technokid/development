<?php
/**
 * Created by Serhii Dudik.
 * User: dudman
 * Date: 11.02.15
 * E-mail: duda902@gmail.com
 */
/**
 * Subject interface
 */
interface Entry_Interface
{
	public function get();
}
/**
 * Subject
 */
class Entry implements Entry_Interface
{
	private $_id;
	public function  __construct($id)
	{
		$this->_id;
	}
	public function get()
	{
		return "Entry #{$this->_id} retrieved";
	}
}
/**
 * Proxy
 */
class Entry_ChacheProxy implements Entry_Interface
{
	private $_id;
	public function  __construct($id)
	{
		$this->_id;
	}
	public function get()
	{
		static $entry = null;
		if ($entry === null) {
			$entry = new Entry($this->_id);
		}
		return $entry->get();
	}
}

/**
 * Usage
 */
$entryId = 1;
$entry = new Entry_ChacheProxy($entryId);
echo $entry->get(), "\n"; // loading necessary
echo $entry->get(), "\n"; // loading unnecessary