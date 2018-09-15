<?php require_once 'includes/core.php';

//todo: create authentication service that runs or is initialized in core
if(!$authenticated = isAuthenticated()){
	redirect('/');
}

$userRepository = new UserRepository($database);
$user = $userRepository->fetchUser($_SESSION[SESSION_USER_ID]);

if(isset($_POST['uploadSubmit']))
{
	$uploadService = new UploadService($database);
	$notifications = [];
	$errors = [];
	
	//get form details
	$description = Utilities::post('descriptionInput', '');
	$file = Utilities::files('uploadInput');

	//perform some validation on the file
	if($file)
	{
		if($file['error'] > 0)
		{
			switch($file['error'])
			{
				case UPLOAD_ERR_INI_SIZE:
					$errors[] = 'Your file exceeds the upload limit. The maximum filesize is '.UPLOAD_MAX_FILESIZE_IN_MB.' MB';
				case UPLOAD_ERR_PARTIAL:
					$errors[] = 'Your file was not uploaded completely, please try again.';
				case UPLOAD_ERR_NO_FILE:
					$errors[] = 'You have not specified a file to be uploaded.'; 
				default:
					$errors[] ='The service was unable to upload your file at this time.';
					break;
			}
		}
		else
		{		
			if(!$uploadService->validateExtension($file['name'])){
				$errors[] = 'Invalid extension for avatar. Accepted extensions are: '.implode(', ', $acceptedExtensions);
			}
			
			if(!$uploadService->validateUploadFilesize($file['size'])){
				$errors[] = 'Your file exceeds the upload limit. The maximum filesize is '.UPLOAD_MAX_FILESIZE_IN_MB.' MB';
			}

			//todo: check for filetype which should be application/x-zip-compressed
		}
	}
	else
	{
		//even without fileupload the array should be populated with error message, this else shouldn't ever be invoked
		//instead the UPLOAD_ERR_NO_FILE error flag will be set
		$errors[] = 'You have not specified a file to be uploaded.'; 
	}
	
	if(count($errors) == 0)
	{
		$filename = $file['name'];		
		$generatedName = $uploadService->generateUniqueName();

		$uploadDir = IO::pathCombine('uploads', $user->id);
		
		if(!file_exists($uploadDir)){
			mkdir($uploadDir, 0777, true);
		}
		
		$uploadPath = IO::pathCombine($uploadDir, $generatedName); 
		
		while(file_exists($uploadPath)){
			$generatedName = $uploadService->generateUniqueName();
			$uploadPath = IO::pathCombine($uploadDir, $generatedName);
		}
		
		//verify if mysqli_real_escape_string needs to be called in combination with prepared statements and sql parameters
		$description = mysqli_real_escape_string($database, $description);
		$filesize = filesize($file['tmp_name']);

		if($uploadService->insert($user->id, $filename, $generatedName, $filesize, $description)) {
			if(move_uploaded_file($file['tmp_name'], $uploadPath)) {
				$notifications[] = 'You have uploaded your file successfully.';
			} else {
				$errors[] = 'Unable to write '.$filename.' to the file system.';
			}
		} else {
			$errors[] = $filename.' could not be added to the database.';
		}
	}
}

$database->close();

?>
<?php require_once 'includes/header.php'; ?>
<main>
	<?php require_once 'includes/tabheader.php'; ?>
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
						<small id="uploadHint" class="form-text text-muted">Only files under <?=UPLOAD_MAX_FILESIZE_IN_MB?> MB with the *.zip extension are accepted.</small>
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
