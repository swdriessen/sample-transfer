<?php require_once 'includes/core.php';

if($authenticated = isAuthenticated())
{
	$userRepository = new UserRepository($database);
	if($user = $userRepository->fetchUser($_SESSION[SESSION_USER_ID]??0)){

		$uploadService = new UploadService($database);
		$uploads = $uploadService->getUploads($user->id);
	} else {
		$authenticated = false;
	}

	if(isset($_POST['delete'])){
		
	}
}
?>
<?php include_once 'includes/header.php'; ?>
<main class="">
	<?php if(!$authenticated): ?>
	<div class="jumbotron jumbotron-fluid jumbotron-code" style="margin-bottom: 0; position: relative">
		<div class="container">
			<h1 class="display-4"><?=PROJECT_NAME?></h1>
			<p class="lead">The most secure way to transfer your homework files.</p>
			<a class="btn btn-github rounded mt-4" href="/auth/github"><i class="fab fa-github mr-2" style="font-size: 1rem;"></i>Sign in with GitHub</a>
		</div>
		<div class="hero-overlay-divider">
			<svg class="hero-overlay-divider-shape" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
				<path d="M 0 14 s 88.64 3.48 300 36 c 260 40 514 27 703 -10 l 12 28 l 3 36 h -1018 z"></path>
				<path d="M 0 45 s 271 45.13 500 32 c 157 -9 330 -47 515 -63 v 86 h -1015 z"></path>
				<path d="M 0 58 s 188.29 32 508 32 c 290 0 494 -35 494 -35 v 45 h -1002 z"></path>
			</svg>
		</div>
	</div>
	<?php endif; ?>	
	
	<?php if($authenticated): ?>
	<?php require_once 'includes/tabheader.php'; ?>
	<?php endif; ?>

	<div class="container">		
		<?php if($authenticated): ?>
		

		<div class="card mb-4">
			<div class="card-header">
				Uploads (<?=count($uploads)?>)
			</div>
			<div class="card-body">
				<?php if(isset($uploads)): ?>
				<?php foreach($uploads as $upload): ?>
				<div class="media text-muted pt-3">
					<!-- <img src="https://picsum.photos/32/32/?image=563" alt="" class="mr-2 rounded"> -->
					<div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
						<div class="d-flex justify-content-between align-items-center w-100">
							<strong class="text-gray-dark"><a href="/downloads/<?=$upload->localfilename?>" class=""><?=$upload->filename?></a></strong>
							<div class="">
								<a href="/downloads/<?=$upload->localfilename?>" class="btn btn-info btn-sm rounded"><i class="fas fa-share"></i></a>
								<!-- <a href="#" class="text-danger"><i class="fas fa-trash"></i></a> -->

								<!-- <div class="btn-group">
									<a href="/uploads/<?=$upload->userId?>/<?=$upload->filename?>" class="btn btn-secondary"><i class="fas fa-cloud-download-alt mr-2"></i>Download</a>
									<button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown"><i class="fas fa-caret-down"></i></button>
									<div class="dropdown-menu dropdown-menu-right">
										<a class="dropdown-item text-danger" href="/delete/<?=$upload->userId?>/<?=$upload->filename?>">Delete</a>
									</div>
								</div>  -->
							</div>
						</div>
						<span class="d-block"><?=$upload->description?></span>
						<span class="d-block"><?=$upload->getDisplayFilesize()?></span>
						<span class="d-block"><strong>Downloads:</strong> <?=$upload->downloads?></span>
					</div>
				</div>
				<?php endforeach; ?>
				<?php endif; ?>			
				<small class="d-block text-right mt-3">
					<a href="/upload">New Upload</a>
				</small>
			</div>
		</div>


<!-- Example split danger button -->
<!-- <div class="btn-group">
  <a href="#" class="btn btn-danger">Action</a>
  <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="sr-only">Toggle Dropdown</span>
  </button>
  <div class="dropdown-menu">
    <a class="dropdown-item" href="#">Action</a>
    <a class="dropdown-item" href="#">Another action</a>
    <a class="dropdown-item" href="#">Something else here</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="#">Separated link</a>
  </div>
</div> -->

		<?php else: ?>	
		<section>
			<h2>Super Feature</h2>
			<p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptate, consectetur mollitia architecto impedit debitis asperiores ipsam. Totam rem ut enim! Odit rerum modi dolor esse ullam inventore illo, sequi quibusdam voluptas, quisquam expedita unde fugiat laboriosam ducimus cumque! Dolorum, quaerat quasi. Earum quia laborum alias eos. Deleniti non ipsa unde quibusdam! Minima tempore amet quibusdam harum voluptatibus eos reiciendis maiores fugiat sequi sed, iure ipsa eligendi adipisci dicta, laboriosam porro hic. Ipsa minima ut doloremque, ducimus quis quo dolore recusandae aliquid voluptatum est neque, fugiat reiciendis veniam, molestiae magni ipsam. Tenetur voluptatem itaque in cum ratione a perferendis, veritatis perspiciatis.</p>
		</section>
		<section>
			<h2>Another Cool Feature</h2>
			<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Accusantium repudiandae totam in dolorem earum esse illo hic nihil error? Voluptatum culpa sint consequuntur, placeat maxime ab facere dolores error, est rem explicabo quibusdam quasi facilis magnam quae dolore saepe cum aliquam doloremque dolorem, suscipit at nulla reprehenderit? Accusantium placeat nihil dolore. Tenetur esse maxime reprehenderit quod sequi impedit excepturi repellendus eos accusamus, dolor nulla labore numquam, sit suscipit! Voluptatem officiis doloribus est molestias impedit debitis nam animi vero, aut quia inventore a laudantium numquam eligendi ducimus magni rem sequi necessitatibus. Recusandae ipsam ipsa cumque aut ratione soluta laboriosam cum corrupti?</p>
			<p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Doloribus, totam.</p>
		</section>
		<section>
			<h2>Coming Soon: Even More Amazing Features</h2>
			<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus minima tempore aliquid, porro, architecto ipsa facere iusto delectus sequi rem ut quae magni aut. Iste suscipit itaque odit architecto delectus.</p>
			<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Accusantium repudiandae totam in dolorem earum esse illo hic nihil error? Voluptatum culpa sint consequuntur, placeat maxime ab facere dolores error, est rem explicabo quibusdam quasi facilis magnam quae dolore saepe cum aliquam doloremque dolorem, suscipit at nulla reprehenderit? Accusantium placeat nihil dolore. Tenetur esse maxime reprehenderit quod sequi impedit excepturi repellendus eos accusamus, dolor nulla labore numquam, sit suscipit! Voluptatem officiis doloribus est molestias impedit debitis nam animi vero, aut quia inventore a laudantium numquam eligendi ducimus magni rem sequi necessitatibus. Recusandae ipsam ipsa cumque aut ratione soluta laboriosam cum corrupti?</p>
		</section>
		<?php endif; ?>						
	</div>
</main>
<?php include_once 'includes/footer.php'; ?>