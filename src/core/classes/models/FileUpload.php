<?php

class FileUpload
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
	
	//todo: propert implementation

	// public function __construct($userId, $filename, $description = ''){
	// 	$this->userId = $userId;
	// 	$this->filename = $filename;
	// 	$this->description = $description;		
	// 	$this->uploadDate = date('Y-m-d H:i:s', time());
	// 	$this->expirationDate = date('Y-m-d H:i:s', time() + 60 * 60 * 24 * 14);		
	// }



	public function getDisplayFileSize(){

		$value = $this->filesize;
		$type = 'b';
		if($value>1024){
			$value = $value/1024;
			$type = 'KB';
		}
		if($value>1024){
			$value = $value/1024;
			$type = 'MB';
		}
		
		return round($value, 2).' '.$type;
	}

}
