<?php require_once 'includes/core.php';

parse_str($_SERVER['QUERY_STRING'], $parameters);

$file = $parameters['file']; //example: 5b9a98f8c6e28

$uploadService = new UploadService($database);
if($download = $uploadService->getDownload($file)){
	//change to just checking if the file is available, do this logic in the service...
	//its fine for current prototype
	$exists = true;
	$now = new DateTime();
	$date = DateTime::createFromFormat('Y-m-d H:i:s', $download->expirationDate);
	$expired = $date < $now;


	//todo: read filesize if exists,
	//display size
	//display expiration date
	$displayDate = date("F jS, Y", strtotime($download->expirationDate));
	



} else {
	$exists = false;
}









if($authenticated = isAuthenticated())
{
	$userRepository = new UserRepository($database);
	if($user = $userRepository->fetchUser($_SESSION[SESSION_USER_ID]))
	{

	}
	else
	{
		$authenticated = false;
	}
}
?>
<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>BPI06 Transfer</title>

		<meta name="robots" content="noindex, nofollow">

		<link rel="shortcut icon" href="https://transfer.swdriessen.nl/favicon.ico?v=2" />

		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700">
		<link rel="stylesheet" href="/css/bootstrap.css">
		<link rel="stylesheet" href="/css/site.css">
		<style>
			footer {
				background-color: #00000099;
			}
		</style>
	</head>
	<body class="d-flex w-100 h-100" style="background: url('https://picsum.photos/1920/?random') center center;background-size:cover;">
		<div class="mx-auto my-auto p-4" style="align-items: center;justify-content: center;">
			<div class="text-center text-light rounded p-4" style="background-color: rgba(0,0,0,0.4);background-color:#00000077">		
				<h1 class="display-4"><a href="/" class="text-light"><?=PROJECT_NAME?></a></h1>
				<p class="lead mb-4">The most secure way to transfer your homework files.</p>
				<?php if($exists): ?>
					<?php if($expired): ?>
					<p class="lead">Your download has expired.</p>
					<a class="btn btn-warning rounded my-4" href="/">File Expired</a>
					<p><small style="opacity: 0.5">This file expired on <?=$displayDate?></small></p>
					<?php else: ?>
					<!-- <p class="lead mt-4">Your download is ready.</p> -->

					<button class="btn btn-success rounded my-4" onclick="serveFile('<?=$file?>')"><?=$download->filename?> (<?=$download->getDisplayFileSize()?>)</button>
					<p><span class="d-block"><?=$download->description?></span>
					<small style="opacity: 0.5">This file is available until <?=$displayDate?></small>
				</p>
					
					<?php endif; ?>
				<?php else: ?>
					<a class="btn btn-danger rounded my-4" href="/">File Not Found</a>
				<?php endif; ?>
			</div>
		</div>
	<?php include_once 'includes/footer.php'; ?>