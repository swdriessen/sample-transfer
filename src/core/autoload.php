<?php

spl_autoload_register(function($class){
	$path = __DIR__.'/classes/'.$class.'.php';
	if (file_exists($path)) { 
		require($path); 
	}
	return class_exists($class);
});

spl_autoload_register(function($class){
	$path = __DIR__.'/classes/models/'.$class.'.php';
	if (file_exists($path)) { 
		require($path); 
	}
	return class_exists($class);
});

spl_autoload_register(function($class){
	$path = __DIR__.'/classes/services/'.$class.'.php';
	if (file_exists($path)) { 
		require($path); 
	}
	return class_exists($class);
});

spl_autoload_register(function($class){
	$path = __DIR__.'/classes/utilities/'.$class.'.php';
	if (file_exists($path)) { 
		require($path); 
	}
	return class_exists($class);
});