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
	public static function post($name){
		return $_POST[$name] ?? null;
	}

}