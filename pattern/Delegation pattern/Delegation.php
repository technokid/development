<?php
/**
 * Created by Serhii Dudik.
 * User: dudman
 * Date: 11.02.15
 * E-mail: duda902@gmail.com
 */
class A {

	public function f() {
		print "А: Вызываем метод f()<br />";
	}

	public function g() {
		print "А: Вызываем метод g()<br />";
	}
}

class C {

	private $_a;

	public function __construct() {
		$this->_a = new A;
	}

	public function f() {
		$this->_a->f();
	}

	public function g() {
		$this->_a->g();
	}

	public function y() {
		print "C: вызываем метод y()<br />";
	}
}

$obj = new C;
$obj->f();
$obj->g();
$obj->y();