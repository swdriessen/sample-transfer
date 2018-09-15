<?php require_once 'includes/core.php';
//todo: move all logic out of public scripts...
parse_str($_SERVER['QUERY_STRING'], $parameters);
$file = $parameters['file']; //example: 5b9a98f8c6e28

$uploadService = new UploadService($database);
if($download = $uploadService->getDownload($file))
{
	$exists = true;
	$now = new DateTime();
	$date = DateTime::createFromFormat('Y-m-d H:i:s', $download->expirationDate);
	$expired = $date < $now;
	if(!$expired)
	{
		//todo: move uploads out of public folder
		//IO::getUploadPath($download); //something like this

		//due to /serve/ ?
		$filepath = 'uploads/'.$download->userId.'/'.$download->localfilename;
		if(!file_exists($filepath)){
			//404
			$test = false;
		}

		$uploadService->updateDownloadCount($download->id, ($download->downloads+1));
		//check fileexists
		//$download->filesize

		// headers to send your file
		header("Content-Type: application/zip");
		header("Content-Length: " . filesize($filepath));
		header('Content-Disposition: attachment; filename="' . $download->filename . '"');

		// upload the file to the user and quit
		readfile($filepath);
		die();
	}
	else
	{
		//404 expired
	}
}
else
{
	//404
}

die();