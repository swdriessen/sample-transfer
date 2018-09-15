<?php require_once 'includes/core.php';

//handle callback
//todo: move to core
if(isset($_GET['code']) ){
	$code = $_GET['code'];
	
	
	$logger = new Logger(__DIR__.'/logs/logs.txt', 'callback.php');
	$logger->log('initialize github callback with code: '.$code);

	$service = new GitHubAuthenticationService(CLIENT_ID, CLIENT_SECRET, REDIRECT_URL);
	$service->requestAccess($code);
	
	$jsonObject = $service->getUser(); //getUser($service->getAccessToken());
	
	//$logger->log((string)json_encode($jsonObject));

	$repository = new UserRepository(create_connection());
	
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

		$logger->log('creating new user: '.$jsonObject->name.' iden:'.$jsonObject->id);
		if($newId = $repository->create($user))
		{
			$user->id = $newId;
			$logger->log('returned id from new user is: '.$newId);
			setUserSessionDetails($user);
			$logger->log('created user '.$user->displayname.' successfully');
			$_SESSION[SESSION_USER_AUTHENTICATED] = true;
		} 
		else 
		{
			$logger->log('unable to create user '.$user->displayname);
		}
	} 
	else 
	{
		$existingUser = $repository->fetchGitHubUser($jsonObject->id);

		//todo: update information if updated_at is recent or preferable compare to value in table, need to store more info or store the entire json object (the lazy way)
		//$jsonObject->updated_at;

		setUserSessionDetails($existingUser);
		$_SESSION[SESSION_USER_AUTHENTICATED] = true;
		$logger->log('authenticated user: '.$existingUser->displayname." ($existingUser->id)");
	}
	
	$repository->close();
}



redirect('/');