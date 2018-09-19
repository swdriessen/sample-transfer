<?php require_once 'includes/core.php';
//simple redirect to avoid showing the full url in links

if(IN_DEVELOPMENT_MODE) {
	authenticateDevelopmentUser();
	redirect('/');
}

//send user to the github authenticate url
redirect(GitHubAuthenticationService::GetAuthorizeUrl());