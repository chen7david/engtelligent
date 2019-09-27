<?php
namespace Core\Model;
/**
 * 
 */
class Hash
{
	static function render($length = null){
		if ($length) {
			return substr(hash("sha512", mt_rand()), 0, $length);
		}
		return hash("sha512", mt_rand());
	}

	static function encode($string = null, $length = null){

		if ($string && $length) {
			return substr(hash("sha512", $string), 0, $length);

		}else if ($string) {
			return hash("sha512", $string);
		}
	}

	static function salt(){
		return self::render();
	}

	static function make($password,$salt){
		$phrase = $password.$salt;
		return self::encode($phrase);
	}
}