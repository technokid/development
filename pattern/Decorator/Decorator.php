<?php
/**
 * Created by Serhii Dudik.
 * User: dudman
 * Date: 11.02.15
 * E-mail: duda902@gmail.com
 */
class ContentRowArray extends ArrayObject
{
}

class Dao_Comment
{
	public function fetchAll()
	{
		return new ContentRowArray(array(
			array("title" => 'Lorem [b]ipsum[/b]', 'body' => 'Lorem ipsum'),
			array("title" => 'Lorem ipsum', 'body' => 'Lorem <script>alert(1);</script>ipsum')
		));
	}
}

class ContentRowListDecorator
{
	private $_rowArray;
	public function  __construct(ContentRowArray &$rowArray)
	{
		$this->_rowArray = &$rowArray;
	}
	public function parseBBCode()
	{
		$this->_rowArray = new ContentRowArray(array_map(function ($li) {
				// do parsing
				return preg_replace("/\[b\](.*?)\[\/b\]/is", "<b>\\1</b>", $li); }
			, $this->_rowArray->getArrayCopy()));
	}
	public function breakLongStrings()
	{
		//..
	}
	public function stripXss()
	{
		$this->_rowArray = new ContentRowArray(array_map(function ($li) {
				// do stripping
				return preg_replace("/(<script.*?>.*?<\/script>)/", "", $li); }
			, $this->_rowArray->getArrayCopy()));
	}
}

/**
 * Usage
 */
$comment = new Dao_Comment();
$rowArray = $comment->fetchAll();
$decorator = new ContentRowListDecorator($rowArray);
$decorator->parseBBCode();
$decorator->stripXss();
print_r($rowArray);

// Output:
// ContentRowArray Object
// (
//    [storage:ArrayObject:private] => Array
//        (
//            [0] => Array
//                (
//                    [title] => Lorem <b>ipsum</b>
//                    [body] => Lorem ipsum
//                )
//
//            [1] => Array
//                (
//                    [title] => Lorem ipsum
//                    [body] => Lorem ipsum
//                )
//
//        )
//
// )