<?php

date_default_timezone_set('Europe/Amsterdam');

define('DEVELOPMENT_SERVER', 'transfer.localhost');
define('PRODUCTION_SERVER', 'transfer.swdriessen.nl');


define('IN_DEVELOPMENT_MODE', $_SERVER['SERVER_NAME'] == DEVELOPMENT_SERVER);
define('IN_PRODUCTION_MODE', $_SERVER['SERVER_NAME'] == PRODUCTION_SERVER);
define('ENVIRONMENT', IN_PRODUCTION_MODE ? 'production' : 'development');

define('DEBUG_MODE', (IN_DEVELOPMENT_MODE && true));

$file = IN_PRODUCTION_MODE ? __DIR__.'/config/config.json' : __DIR__.'/config/config.development.json';

if(!file_exists($file)){
	die('configuration file is missing: '.$file);
}

$json = json_decode(file_get_contents($file));
//load configuration

//application settings
define('PROJECT_NAME', $json->project_name);

//github oauth
define('CLIENT_ID', $json->github->client_id);
define('CLIENT_SECRET', $json->github->client_secret);
define('REDIRECT_URL', $json->github->redirect_url);

//mysql settings
define('DB_HOST', $json->database->host);
define('DB_NAME', $json->database->name);
define('DB_USER', $json->database->username);
define('DB_PASS', $json->database->password);


if(IN_PRODUCTION_MODE && ($json->github->client_id == '' || $json->github->client_secret == '' || $json->github->redirect_url == '')){
	die('configuration file has invalid values for github oauth');
}

if($json->database->host == '' || $json->database->name == ''){
	die('configuration file has invalid database host or database name');
}

//session variable names
define('SESSION_USER_AUTHENTICATED', 'u_logged');
define('SESSION_USER_ID', 'u_id');
define('SESSION_USER_IDENTIFIER', 'u_identifier');

//upload configuration
define('UPLOAD_MAX_FILESIZE_IN_MB', 20);
define('UPLOAD_MAX_FILESIZE', 1024 * 1024 * UPLOAD_MAX_FILESIZE_IN_MB);