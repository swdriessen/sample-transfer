<?php require_once 'includes/core.php';

//handle callback
//todo: move to core
if(isset($_GET['code']) ){
	$code = $_GET['code'];
	
	Logger::log('initialize github callback with code: '.$code, 'DEBUG');

	$service = new GitHubAuthenticationService(CLIENT_ID, CLIENT_SECRET, REDIRECT_URL);
	$service->requestAccess($code);
	
	$jsonObject = $service->getUser();
	
	//Logger::log((string)json_encode($jsonObject), 'DEBUG');

	$repository = new UserRepository($database);
	
	if(!$repository->existsGitHubUser($jsonObject->id))
	{
		$user = new User();		
		$user->identifier = $jsonObject->id;
		$user->username = $jsonObject->login;
		$user->displayname = $jsonObject->name;
		$user->email = $service->getEmail();
		$user->avatar = $jsonObject->avatar_url;
		$user->profile = $jsonObject->html_url;
		$user->active =  true;

		Logger::log('creating new user: '.$jsonObject->name.' iden:'.$jsonObject->id);
		if($newId = $repository->create($user))
		{
			$user->id = $newId;
			Logger::log('returned id from new user is: '.$newId);
			setUserSessionDetails($user);
			Logger::log('created user '.$user->displayname.' successfully');
			$_SESSION[SESSION_USER_AUTHENTICATED] = true;
		} 
		else 
		{
			Logger::log('unable to create user '.$user->displayname);
		}
	} 
	else 
	{
		$existingUser = $repository->fetchGitHubUser($jsonObject->id);
		
		//todo: update information if updated_at is recent or preferable compare to value in table, need to store more info or store the entire json object (the lazy way)
		//$jsonObject->updated_at;

		setUserSessionDetails($existingUser);
		$_SESSION[SESSION_USER_AUTHENTICATED] = true;
		Logger::log('authenticated user: '.$existingUser->displayname." ($existingUser->id)");
	}
	
	$repository->close();
}

redirect('/');