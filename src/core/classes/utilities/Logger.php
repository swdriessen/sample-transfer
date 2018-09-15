<?php

class Logger {
	private $_path;
	private $_fs;
	
	public function __construct($path, $caller = ''){
		$this->_path = $path;

		$dir = dirname($this->_path);
		if(!file_exists($dir)){
			mkdir($dir, 0777, true);
		}

		$this->_fs = fopen($this->_path, 'a');
		
		$this->log('========== NEW SESSION ==========');
		if($caller != '') {
			$this->log('initialized by '.$caller);
		}
	}

	public function __destruct(){
		fclose($this->_fs);
	}

	public function log($entry){
		fwrite($this->_fs, date("Y/m/d H:m:s", time())."\t".$entry.PHP_EOL);
	}
}