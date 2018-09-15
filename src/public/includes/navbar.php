<?php

$request = $_SERVER['REQUEST_URI'];

?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<div class="container">		
		<a class="navbar-brand" href="/">
			<img src="/images/icon.png" width="30" height="30" class="d-inline-block align-top mr-2" alt="">
			BPI06 Transfer
		</a>
		<!-- <a class="navbar-brand" href="/">BPI06 Transfer</a> -->
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="mainNavbar">
			<ul class="navbar-nav mr-auto">
				<?php if($authenticated): ?>
				<li class="nav-item">
					<a class="nav-link <?=$request=='/upload'?'active':''?>" href="/upload"><i class="d-inline-block d-sm-none fas fa-cloud-upload-alt mr-2"></i>New Upload</a>
				</li>
				<?php endif; ?>
			</ul>
			<ul class="navbar-nav ml-auto">
				<?php if($authenticated): ?>
				<!-- <li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=$user->displayname?></a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="<?=$user->profile?>" target="_blank">GitHub Profile Page</a>
						<a class="dropdown-item" href="/logout">Sign Out</a>
					</div>
				</li> -->
				<!-- <li class="nav-item">
					<a class="nav-link <?=$request=='/upload'?'active':''?>" href="/upload"><i class="d-inline-block d-sm-none fas fa-cloud-upload-alt mr-2"></i>New Upload</a>
				</li> -->
				
				<?php else: ?>
				<li class="nav-item">
					<a class="nav-link" href="/auth/github"><i class="fab fa-github mr-2"></i>Sign in with GitHub</a>
				</li>
				<?php endif; ?>
				<?php if($authenticated): ?>
				<li class="nav-item">
					<a class="nav-link" href="/logout" title="Sign Out"><i class="fas fa-sign-out-alt text-warning"></i><span class="d-inline-block d-sm-none ml-2">Sign Out</span></a>
				</li>
				<?php endif; ?>
			</ul>

		</div>
	</div>
</nav>