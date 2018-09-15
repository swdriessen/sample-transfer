<?php
$request = $_SERVER['REQUEST_URI'];
//Utilities::dump($request);
?>
<div class="tab-container">
	<div class="container">
		<div class="tab-header clearfix">
			<img src="<?=$user->avatar?>" alt="<?=$user->displayname?>'s Avatar" title="<?=$user->displayname?>'s Avatar" class="avatar float-left">
			<div class="float-left ml-2">
				<span class="d-block"><strong><?=$user->displayname?></strong></span>
				<span class="d-block text-muted"><small><?=$user->email?></small></span>
			</div>
		</div>
		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a class="nav-link <?=$request=='/'?'active':''?>" href="/">Your Uploads</a>
			</li>
			<li class="nav-item">
				<a class="nav-link <?=$request=='/upload'?'active':''?>" href="/upload">New Upload</a>
			</li>
		</ul>
	</div>
</div>