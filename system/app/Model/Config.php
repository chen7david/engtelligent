<?php
namespace Core\Model;

class Config {

	public static function get($path){

		if (isset($_SESSION['config'])) {

			$index = $_SESSION['config'];

			$path = explode(".", $path);

			foreach ($path as $key) {

				if (isset($index[$key])) {

					$index =  $index[$key];
				
				}else {
					return "";
				}
			}

			return $index;
		}
	}
		
}

