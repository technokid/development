<?php
/**
 * Created by Serhii Dudik.
 * User: dudman
 * Date: 11.02.15
 * E-mail: duda902@gmail.com
 */

abstract class Dao_Abstract
{
	protected $_connection;
	protected $_primaryKey;
	protected $_tableName;

	public function  __construct($connection)
	{
		$this->_connection = $connection;
	}
	public function find($value, $key = NULL)
	{
		if (is_null($key)) {
			$key = $this->_primaryKey;
		}
		return $this->_connection->fetch(sprintf(
			"SELECT * FROM %s WHERE %s = '%s'", $this->_tableName, $this->_primaryKey, $value));
	}
	public function findAll($value, $key = NULL)
	{
		//..
	}
	public function insert($assocArray)
	{
		//..
	}
	public function update($assocArray)
	{
		//..
	}
	public function delete($key = NULL)
	{
		//..
	}
}

class Dao_User extends Dao_Abstract
{
	protected $_primaryKey = "userId";
	protected $_tableName = "User";

	public function findByEmail($email)
	{
		return $this->find($email, 'email');
	}
}

/**
 * Usage
 */
$user = Dao_User(Lib_Db::getInstance('masterDb'));
$user->findByEmail('admin@thewall.we');