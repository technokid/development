<?php
/**
 * Created by Serhii Dudik.
 * User: dudman
 * Date: 11.02.15
 * E-mail: duda902@gmail.com
 */

class Lib_String
{
	public static function parseHomographs($text)
	{
		static $homographs = null;
		if ($homographs === null) {
			// include "../homographs.php"
			$homographs = array(); // TILT
		}
		$text = strtr($text, $homographs);
	}
	public static function removeControlChars($text)
	{
		$text = preg_replace('#(?:[\x00-\x1F\x7F]+|(?:\xC2[\x80-\x9F])+)#', '', $text);
	}
	public static function removeMultipleSpaces($text)
	{
		$text = preg_replace('# {2,}#', ' ', $text);
	}
}

class Model_UserFacade
{
	public function getCleanUsername($username)
	{
		$username = Lib_String::parseHomographs($username);
		$username = Lib_String::removeControlChars($username);
		$username = Lib_String::removeMultipleSpaces($username);
		return trim($username);
	}
}