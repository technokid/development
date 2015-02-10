<?php
/**
 * Created by Serhii Dudik.
 * User: dudman
 * Date: 11.02.15
 * E-mail: duda902@gmail.com
 */
// класс для хранения данных о сотруднике
class Employee {

	private $_name;
	private $_departament;

	public function __construct($name, $departament) {
		$this->_name = $name;
		$this->_departament = $departament;
	}

	public function getName() {
		return $this->_name;
	}

	public function getDepartament() {
		return $this->_departament;
	}
}

// класс для хранения списка объектов
class ObjectList {

	private $_objList;

	public function __construct() {
		$this->free();
	}
	/**
	 *чтобы не скучать!
	 */
	public function free() {
		$this->_objList = array();
	}

	public function count() {
		return count($this->_objList);
	}

	public function add($obj) {
		array_push($this->_objList, $obj);
	}

	public function remove($obj) {
		$k = array_search( $obj, $this->_objList, true );
		if ( $k !== false ) {
			unset( $this->_objList[$k] );
		}
	}

	public function get($index) {
		return $this->_objList[$index];
	}

	public function set($index, $obj) {
		$this->_objList[$index] = $obj;
	}
}

// класс для хранения сотрудников
class EmployeeList {

	// объект класса "список объектов"
	private $_employeersList;

	public function __construct(){
		// создаём объект методы которого будем делегировать
		$this->_employeersList = new ObjectList;
	}

	public function getEmployer($index) {
		return $this->_employeersList->get($index);
	}

	public function setEmployer($index, Employee $objEmployer) {
		$this->_employeersList->set($index, $objEmployer);
	}

	public function __destruct() {
		$this->_employeersList->free();
	}

	public function add(Employee $objEmployer) {
		$this->_employeersList->add($objEmployer);
	}

	public function remove(Employee $objEmployer) {
		$this->_employeersList->remove($objEmployer);
	}

	// последовательный поиск сотрудника по имени
	// через аргумент $offset можно задавать позицию с которой вести поиск.
	// если сотрудник не найден вернёт значение меньше ноля (-1)
	public function getIndexByName($name, $offset=0) {
		$result = -1; // предполагаем, что его нету в списке
		$cnt = $this->_employeersList->count();
		for ($i = $offset; $i < $cnt; $i++) {
			if ( !strcmp( $name, $this->_employeersList->get($i)->getName() ) ) {
				$result = $i;
				break;
			}
		}
		return $result;
	}
}

$obj1 = new Employee("Танасийчук Степан", "web студия");
$obj2 = new Employee("Кусый Назар", "web студия");
$obj3 = new Employee("Сорока Орест", "web студия");

$objList = new EmployeeList();
$objList->add($obj1);
$objList->add($obj2);
$objList->add($obj3);

echo "<pre>";
print_r($objList);

echo "<hr>";

$index = $objList->getIndexByName("Кусый Назар");
$obj4 = $objList->getEmployer($index);
print_r($obj4);

echo "<hr>";

$objList->setEmployer(2, $obj4);
print_r($objList);
echo "</pre>";