<?php

function kill($obj = null){
	echo "<pre>";
	if ($obj != null) {
		if (is_array($obj)) {
			print_r($obj);
		}else if(is_string($obj)){
			echo $obj;
		}else{
			var_dump($obj);
		}
	}
	echo "<hr>";
	die();
}




function config($path){

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

function makedir($dir){
	$path = getcwd().$dir;
     if (!file_exists($path)) {
          mkdir($path, 0777, true);
     }
     return $path;
}

