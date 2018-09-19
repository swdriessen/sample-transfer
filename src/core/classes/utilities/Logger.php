<?php

final class Logger {
	private static $_loggers = [];

	public function __destruct(){
		foreach(self::$_loggers as $logger){
			$logger->__destruct();
		}
	}
	
	public static function registerLogger(LoggerInterface $logger){
		self::$_loggers[] = $logger;
	}

	//todo: create log level constants
	private static function log($log, $level = ''){
		foreach(self::$_loggers as $logger){
			$logger->log($log, $level);
		}
	}
	
	public static function debug($log){
		self::log($log, 'debug');
	}

	public static function info($log){
		self::log($log, 'info');
	}

	public static function warning($log){
		self::log($log, 'warning');
	}
}