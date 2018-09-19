<?php

class Utilities {

	public static function pre($input){
		echo '<pre>'.$input.'</pre>';
	}
	public static function dump($input){
		echo '<pre>'.var_dump($input).'</pre>';
	}
	public static function dump_r($input){
		echo '<pre>'.print_r($input).'</pre>';
	}

	public static function post($name, $default = null){
		return $_POST[$name] ?? $default;
	}
	public static function get($name, $default = null){
		return $_GET[$name] ?? $default;
	}
	public static function files($name, $default = null){
		return $_FILES[$name] ?? $default;
	}
	
}