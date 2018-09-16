<?php

class FileLogger implements LoggerInterface {
	private $_path;
	private $_fs;
	
	public function __construct($path){
		$this->_path = $path;
		
		$dir = dirname($this->_path);
		if(!file_exists($dir)){
			mkdir($dir, 0777, true);
		}
		
		//open file for appending logs
		$this->_fs = fopen($this->_path, 'a');
		$this->log('#################### NEW SESSION ####################', '');
	}
	
	public function __destruct(){
		fclose($this->_fs);
	}
	
	public function log($log, $level){
		$parts = [ date("Y-m-d H:m:s", time()) ];

		if($level != ''){
			$parts[] = strtoupper($level);
		}
		
		$parts[] = $log;
		
		fwrite($this->_fs, implode(" | ", $parts).PHP_EOL);
	}
}
