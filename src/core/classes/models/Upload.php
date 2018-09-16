<?php

class Upload
{
	public $id;
	public $userId;
	public $filename;
	public $localfilename;
	public $filesize;
	public $description;
	public $uploadDate;
	public $expirationDate;
	public $downloads;
	
	public function __construct(){
		$this->id = 0;
		$this->userId = 0;
		$this->filename = '';
		$this->localfilename = '';
		$this->filesize = 0;
		$this->description = '';
		$this->uploadDate = date('Y-m-d H:i:s', time());
		$this->expirationDate = date('Y-m-d H:i:s', time() + 60 * 60 * 24 * 7);
		$this->downloads = 0;
	}
	
	public static function constructFromDatabase($id, $userId, $filename, $localFilename, $filesize, $description, $uploadDate, $expirationDate, $downloads){
		$instance = new self();
		
		$instance->id = $id;
		$instance->userId = $userId;
		$instance->filename = $filename;
		$instance->localfilename = $localFilename;
		$instance->filesize = $filesize;
		$instance->description = $description;
		$instance->uploadDate = $uploadDate;
		$instance->expirationDate = $expirationDate;
		$instance->downloads = $downloads;

		return $instance;
	}
	
	public function getDisplayFilesize(){
		$value = $this->filesize;
		$type = 'B';
		
		if($value > 1024) {
			$value /= 1024;
			$type = 'kB';
		}		
		if($value > 1024) {
			$value /= 1024;
			$type = 'MB';
		}

		return round($value, 2).' '.$type;
	}

	public function __toString(){
		return $this->filename;
	}
}
