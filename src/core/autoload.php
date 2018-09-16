<?php

spl_autoload_register(function($class){

	//todo: get subdirecties instead of having to list them all
	$directories = [
		'classes/',
		'classes/models/',
		'classes/services/',
		'classes/utilities/',
		'interfaces/',
	];
	
	foreach($directories as $dir){
		$path = __DIR__.'/'.$dir.$class.'.php';
		if (file_exists($path)) { 
			require($path); 
			break;
		}
	}
	
	return class_exists($class);
});