<?php

require_once 'includes/core.php';

$authenticated = isAuthenticated();

if(!$authenticated){
	redirect('/');
}

$connection = create_connection();

$userRepository = new UserRepository($connection);
$user = $userRepository->fetchUser($_SESSION[SESSION_USER_ID]);

if($authenticated && $isPost = isset($_POST['uploadSubmit']))
{
	$uploadService = new UploadService($connection);
	
	$errors = array();

	$description = $_POST['descriptionInput'] ?? '';
	$file = $_FILES['uploadInput'] ?? null;
	
	if($file == null) { 
		$errors[] = 'No file specified.'; 
	}
	
	if($file['error'] > 0) {
		$errors[] = get_upload_error($file['error']);
	} else {
				
		if(!$uploadService->validateExtension($file['name'])){
			$errors[] = 'Invalid extension for avatar. Accepted extensions are: '.implode(', ', $acceptedExtensions);
		}

		if($file['size'] > UPLOAD_MAX_FILESIZE){
			$errors[] = 'Your file is too large, the maximum max size is '.UPLOAD_MAX_FILESIZE / (1024 * 1024). 'MB';
		}
	}

	if(count($errors) == 0)
	{
		$info = pathinfo($file['name']);

		$originalFilename = $info['filename'].'.'.$extension;

		$prefix = strtolower($info['filename']).'_';

		$userId = $_SESSION[SESSION_USER_ID];

		$uniqueFilename = IO::getUniqueFilename();

		$uploadDir = IO::pathCombine('uploads', $userId);
		
		// if(!file_exists('uploads')){
		// 	$created = mkdir('uploads', 0777, true);
		// 	pre('created uploads '.$created);
		// }

		if(!file_exists($uploadDir)){
			$created = mkdir($uploadDir, 0777, true);
			//pre('created'.$uploadDir.' '.$created);
		}

		$path = IO::pathCombine($uploadDir, $uniqueFilename); 

		while(file_exists($path)){
			$uniqueFilename = IO::getUniqueFilename();
			$path = IO::pathCombine($uploadDir, $uniqueFilename);
		}

		//name = filename
		//tmp_name =  C:\Development\wamp\tmp\phpAB80.tmp
		//size  

		

		/*
		if(!create_upload_row($connection, $userId, $uniqueFilename, $description)){
			$errors[] = 'not added to database';
		}
		*/



		//add entry to the database to keep track of uploaded files
		$description = mysqli_real_escape_string($connection, $description);

		$filesize = filesize($file['tmp_name']);

		if($uploadService->insert($userId, $originalFilename, $uniqueFilename, $filesize, $description)) {
			//move the file to the destination
			$source = $file['tmp_name'];
			$destination = $path;

			if(move_uploaded_file($source, $destination)) {
				$notifications[] = 'You have uploaded your file successfully.';
			} else {
				$errors[] = $originalFilename.' could not be moved into the upload directory of user '.$userId;// 'Moving file failed.';
			}
		} else {
			$errors[] = $originalFilename.' could not be added in the table by user '.$userId;
		}
	}
}

mysqli_close($connection);

?>
<?php include_once 'includes/header.php'; ?>
<main>
	<!-- <div class="jumbotron jumbotron-fluid jumbotron-code jumbotron-code-info" style="margin-bottom: 0">
		<div class="container">	
			<h1 class="display-4">New Upload</h1>
			<p class="lead">Have you finished your homework?</p>
		</div>
	</div> -->

	<?php if($authenticated): ?>
	<div class="tab-container">
		<div class="container">
			<div class="tab-header clearfix">
				<img src="<?=$user->avatar?>" alt="<?=$user->displayname?>'s Avatar" title="<?=$user->displayname?>'s Avatar" class="avatar float-left">
				<div class="float-left ml-2">
					<span class="d-block"><strong><?=$user->displayname?></strong></span>
					<span class="d-block text-muted"><small><?=$user->email?></small></span>
				</div>

				<!-- <a class="btn btn-outline-info btn-sm float-right" href="/upload"><i class="fas fa-cloud-upload-alt mr-2"></i>New Upload</a> -->
			</div>
			<!-- <a class="btn btn-info btn-sm float-right" href="/upload"><i class="fas fa-cloud-upload-alt mr-2"></i>New Upload</a> -->
			<ul class="nav nav-tabs">
				<li class="nav-item">
					<a class="nav-link " href="/">Your Uploads</a>
				</li>
				<li class="nav-item">
					<a class="nav-link active" href="/upload">New Upload</a>
				</li>
			</ul>
		</div>
	</div>
	<?php endif; ?>

	<div class="container">	

		<?php if(isset($notifications)&& count($notifications)>0): ?>
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			<?=$notifications[0]?>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<?php endif; ?>

		<?php if(isset($errors)&& count($errors)>0): ?>
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<?=$errors[0]?>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<?php endif; ?>

		<form action="/upload" method="POST" enctype="multipart/form-data" class="form">
			<fieldset>
				<div class="form-group">
					<label for="inputDescription">Short Description</label>
					<input id="inputDescription" name="descriptionInput" type="text" class="form-control" placeholder="">
					<small id="inputDescriptionHint" class="form-text text-muted">You can enter a small description of the uploaded files.</small>
				</div>
				<div class="form-group">
					<div class="custom-file">
						<input type="file" class="custom-file-input" id="customFile" name="uploadInput">
						<label id="customFileLabel" class="custom-file-label" for="customFile">Choose file</label>
						<small id="uploadHint" class="form-text text-muted">Only zipped files under 20Mb with the *.zip extension are accepted.</small>
					</div>		
				</div>						
				<div class="form-group">
					<input type="submit" name="uploadSubmit" value="Upload File" class="btn btn-outline-success">
				</div>
			</fieldset>
		</form>
	</div>
</main>
<?php include_once 'includes/footer.php'; ?>
<script>
	$(document).ready(function()
	{
		$('#customFile').change(function()
		{
			let parts = $(this).val().split('\\');
			let name = parts[parts.length-1];
			$('#customFileLabel').text(name);

			var nameParts = name.split('.')
			var extension = nameParts[nameParts.length-1];

			if(extension!='zip')
			{
				$('#customFileLabel').removeClass('text-success');
				$('#customFileLabel').addClass('text-danger');
			}
			else
			{
				$('#customFileLabel').removeClass('text-danger');
				$('#customFileLabel').addClass('text-success');
			}
		});
	});
	
</script>
