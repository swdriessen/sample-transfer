<?php

class IO {
	public static function pathCombine() {
		$args = func_get_args();
		
		$path = implode(DIRECTORY_SEPARATOR, $args);
		$contains = DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR;

		while(strpos($path, $contains) !== false){
			$path = str_replace($contains, DIRECTORY_SEPARATOR, $path);
		}
		
		return ltrim($path, DIRECTORY_SEPARATOR);
	}
	
	public static function getUniqueFilename($extension = '', $prefix = ''){	

		if($extension==''){
			return uniqid($prefix);
		}
		
		return uniqid($prefix).'.'.$extension;
	}
}