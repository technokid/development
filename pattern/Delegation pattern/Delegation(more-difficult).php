<?php
/**
 * Created by Serhii Dudik.
 * User: dudman
 * Date: 11.02.15
 * E-mail: duda902@gmail.com
 */
// используем интерфейс для безопасности типа
interface I {
	public function f();
	public function g();
}

class A implements I {
	public function f() {
		print "А: Вызываем метод f()<br />";
	}

	public function g() {
		print "А: Вызываем метод g()<br />";
	}
}

class B implements I {
	public function f() {
		print "B: Вызываем метод f()<br />";
	}

	public function g() {
		print "B: Вызываем метод g()<br />";
	}
}

class C implements I {
	private $_i;

	// создаём объект, методы которого будем делегировать
	public function __construct() {
		$this->_i = new A;
	}

	// этими методами меняем поле-объект, чьи методы будем делегировать
	public function toA() {
		$this->_i = new A;
	}

	public function toB() {
		$this->_i = new B;
	}


	// делегированые методы
	public function f() {
		$this->_i->f();
	}

	public function g() {
		$this->_i->g();
	}
}

$obj = new C;
$obj->f();
$obj->g();
$obj->toB();
$obj->f();
$obj->g();