<?php

use System\Config;

// Стандарт
if(!function_exists('config')){
	function config($item){
		$config = new Config();
		return $config -> get($item);
	}
}

if(!function_exists('fileszie')){
	function fileszie($file_size) {

		if ($file_size >= 1073741824) {
			$file_size = round($file_size / 1073741824 * 100) / 100 . " Gb";
		} elseif ($file_size >= 1048576) {
			$file_size = round($file_size / 1048576 * 100) / 100 . " Mb";
		} elseif ($file_size >= 1024) {
			$file_size = round($file_size / 1024 * 100) / 100 . " Kb";
		} else {
			$file_size = $file_size . " b";
		}
		return $file_size;
	}

}





