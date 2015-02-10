<?php
/**
 * Created by Serhii Dudik.
 * User: dudman
 * Date: 11.02.15
 * E-mail: duda902@gmail.com
 */
/**
 * Implementor
 */
interface Dao_API_Interface
{
	public function fetchProfile($guid);
}
/**
 * Concrete implementor 1
 */
class Dao_RemoteServerApi implements Dao_API_Interface
{
	public function fetchProfile($guid)
	{
		return sprintf ("Profile #%d via remote server API\n", $guid);
	}
}
/**
 * Concrete implementor 2
 */
class Dao_LocalApi implements Dao_API_Interface
{
	public function fetchProfile($guid)
	{
		return sprintf ("Profile #%d via local API\n", $guid);
	}
}
/**
 * Abstraction
 */
class Dao_User
{
	private $_api;
	public function  __construct(Dao_API_Interface $api)
	{
		$this->_api = $api;
	}
	public function fetchProfile($guid)
	{
		return $this->_api->fetchProfile($guid);
	}
}

/**
 * Usage
 */
$dao = new Dao_User(new Dao_RemoteServerApi());
print $dao->fetchProfile(1);

// Output:
// Profile #1 via remote server API