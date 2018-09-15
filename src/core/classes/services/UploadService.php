<?php

class UploadService {
	protected $_connection;

	public function __construct($connection){
		$this->_connection = $connection;
	}

	public function getUploads($id){
		$query = "SELECT * FROM uploads WHERE user_id='$id'";
		$result = mysqli_query($this->_connection, $query);

		$uploads = array();
		
		while($row = mysqli_fetch_assoc($result)){

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

			$uploads[] = $upload;
		}

		return $uploads;
	}

	public function createUploadEntry($id, $filename, $local, $filesize, $description){
		$expiration = date('Y-m-d H:i:s',time() + 60 * 60 * 24 * 7); //now + 1 week
		$query = "INSERT INTO uploads(`user_id`, `original_filename`, `local_filename`, `filesize`, `description`, `expiration_date`, `downloads`) VALUES ('$id', '$filename', '$local', '$filesize', '$description', '$expiration', 0);";
		//Utilities::pre($query);
		return mysqli_query($this->_connection, $query);
	}


	public function getDownload($localfilename){
		$query = "SELECT * FROM uploads WHERE local_filename='$localfilename'";
		$result = mysqli_query($this->_connection, $query);

		$uploads = array();
		
		while($row = mysqli_fetch_assoc($result)){

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

			$uploads[] = $upload;
		}

		if(count($uploads)==1)
			return $uploads[0];

		return null;
	}
	


	public function setDownloadCount($id, $newValue){
		$query = "UPDATE `uploads` SET `downloads`='$newValue' WHERE `id`='$id';";
		return mysqli_query($this->_connection, $query);
	}

	public function close(){
		mysqli_close($this->_connection);
	}	
}