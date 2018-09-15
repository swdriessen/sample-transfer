<?php 

//initialize requirements
require_once 'autoload.php';
require_once 'configuration.php';

//initialize file logger
$logger = new Logger(__DIR__.'/logs/log.txt');
$logger->log('running in '.ENVIRONMENT.' environment');
//start session
session_start();

$database = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);



//move into MySqlDatabase.php
function create_connection(){
	return mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
}
function authenticateDevelopmentUser(){
	$repository = new UserRepository(create_connection());
	$existingUser = $repository->fetchGitHubUser('1234567'); //demo user
	setUserSessionDetails($existingUser);
	$_SESSION[SESSION_USER_AUTHENTICATED] = true;
}
function setUserSessionDetails($user){
	$_SESSION[SESSION_USER_ID] = $user->id;
	$_SESSION[SESSION_USER_IDENTIFIER] = $user->identifier;
}

// move old functions into classes

function getAuthorizeUrl($id, $redirect, $scope = 'user:email'){
	$query = implode('&', array('client_id='.$id, 'redirect_url='.$redirect, 'scope='.$scope));
	return 'https://github.com/login/oauth/authorize?'.$query;
}

function isAuthenticated(){
	return isset($_SESSION[SESSION_USER_AUTHENTICATED]) && $_SESSION[SESSION_USER_AUTHENTICATED];
}

function signOut(){
	unset($_SESSION[SESSION_USER_AUTHENTICATED]);
	session_destroy();
}

function redirect($location = '/'){
	header('Location: '.$location);
	die();
}
function get_upload_error($id){
	switch($id)
	{
		case UPLOAD_ERR_INI_SIZE:
			return 'The file exceeds the upload limit.';
		case UPLOAD_ERR_PARTIAL:
			return 'The file was not uploaded fully, please try again.';
		case UPLOAD_ERR_NO_FILE:
			return 'Selecteer een bestand.';
		default:
			echo 'Unable to upload at the moment.';
			break;
	}
}

function generateUniqueFilename($extension, $prefix = ''){	
	return uniqid($prefix).'.'.$extension;
}

