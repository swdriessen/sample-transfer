<?php

class UploadService {
	private $_database;
	
	public function __construct($database){
		$this->_database = $database;	
	}
	
	public function insert($id, $filename, $localFilename, $filesize, $description){
		$query = "INSERT INTO uploads(`user_id`, `original_filename`, `local_filename`, `filesize`, `description`, `expiration_date`, `downloads`) VALUES (?, ?, ?, ?, ?, ?, ?);";
		
		if($statement = $this->_database->prepare($query)){
			//todo: downloads default to 0

			$expiration = $this->getExpirationDate();
			$downloads = 0; //bind param requires actual variables to be passed in
			$statement->bind_param('ississi', $id, $filename, $localFilename, $filesize, $description, $expiration, $downloads); 
			return $statement->execute();
		}
		
		return false;
	}
	public function getUploads($id){
		$query = "SELECT * FROM uploads WHERE user_id=?;";

		if($statement = $this->_database->prepare($query))
		{
			$statement->bind_param('i', $id);
			if($statement->execute()){
				$result = $statement->get_result();

				$uploads = [];				
				while($row = $result->fetch_assoc()){
					$uploads[] = $this->initializeNewUpload($row);
				}
				return $uploads;
			}
		}
		
		return false;
	}	
	public function getDownload($localFilename){
		$query = "SELECT * FROM uploads WHERE local_filename=?;";

		if($statement = $this->_database->prepare($query))
		{
			$statement->bind_param('s', $localFilename);
			if($statement->execute()){
				$result = $statement->get_result();

				if($result->num_rows == 1){
					$row = $result->fetch_assoc();
					return $this->initializeNewUpload($row);
				}
			}
		}
		
		return false;
	}	
	public function updateDownloadCount($id, $newValue){
		$query = "UPDATE `uploads` SET `downloads`=? WHERE `id`=?;";
		
		if($statement = $this->_database->prepare($query)){
			$statement->bind_param('ii', $newValue, $id);
			return $statement->execute();
		}
		
		return false;
	}
	public function close(){
		$this->_database->close();
	}

	//public helper methods
	public function validateExtension($filename){
		$acceptedExtensions = ['zip'];
		$extension = pathinfo($filename, PATHINFO_EXTENSION);	

		return in_array($extension, $acceptedExtensions);
	}
	public function validateUploadFilesize($filesize){
		return $filesize <= UPLOAD_MAX_FILESIZE;
	}
	public function generateUniqueName($extension = ''){
		return IO::getUniqueFilename($extension);
	}

	//helper methods
	private function getExpirationDate($expirationOffsetInSeconds = 604800){
		return date('Y-m-d H:i:s', time() + $expirationOffsetInSeconds);
	}	
	private function initializeNewUpload($row){
		$upload = new Upload();

		$upload->id = $row['id'];
		$upload->userId = $row['user_id'];
		$upload->filename = $row['original_filename'];
		$upload->localfilename = $row['local_filename'];
		$upload->filesize = $row['filesize'];
		$upload->description = $row['description'];
		$upload->uploadDate = $row['upload_date'];
		$upload->expirationDate = $row['expiration_date'];
		$upload->downloads = $row['downloads'];

		return $upload;
	}
}