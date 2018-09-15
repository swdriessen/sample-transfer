<?php

final class GitHubAuthenticationService {
	private $_clientId;
	private $_clientSecret;
	private $_redirectUrl;
	private $_accessToken;

	public function __construct($client, $secret, $redirect){
		$this->_clientId = $client;
		$this->_clientSecret = $secret;
		$this->_redirectUrl = $redirect;
	}

	public static function GetAuthorizeUrl($scope = 'user:email'){
		$query = implode('&', array('client_id='.CLIENT_ID, 'redirect_url='.REDIRECT_URL, 'scope=user:email'));
		
		return 'https://github.com/login/oauth/authorize?'.$query;
	}

	public function getAccessToken(){
		return $this->_accessToken;
	}

	public static function Callback($code){
		$service = new GitHubAuthenticationService(CLIENT_ID, CLIENT_SECRET, REDIRECT_URL);
		$service->requestAccess($code);
		return $service;
	}
	
	public function requestAccess($code){
		$query = http_build_query(array(
			'client_id' => $this->_clientId,
			'redirect_url' => $this->_redirectUrl,
			'client_secret' => $this->_clientSecret,
			'code' => $code,
		));

		//todo: POST | Accept: application/json
		
		$response = file_get_contents('https://github.com/login/oauth/access_token?'.$query);
		
		parse_str($response, $result);

		$this->_accessToken = new GitHubResponseToken($result['access_token'], $result['scope'], $result['token_type']);
	}
	/*
	public function postRequestAccess($code){
		$data = array(
			'client_id' => $this->_clientId,
			'redirect_url' => $this->_redirectUrl,
			'client_secret' => $this->_clientSecret,
			'code' => $code
		);

		$query = http_build_query($data);

		$options = [
			'http' => [
				'method' => 'POST',
				'header' => ['Content-type: application/json\r\n']
			]
		];

		//todo: POST | Accept: application/json
		
		$response = file_get_contents('https://github.com/login/oauth/access_token?'.$query);
		
		parse_str($response, $result);

		$this->_accessToken = new GitHubResponseToken($result['access_token'], $result['scope'], $result['token_type']);
	}
	*/
	private function getAccessTokenQuery(){
		$data = array(
			'access_token' => (string)$this->_accessToken
		);

		return http_build_query($data);
	}
	private function getStreamContext(){
		$options = [
			'http' => [
				'method' => 'GET',
				'header' => ['User-Agent: PHP']
			]
		];
		
		return stream_context_create($options);
	}

	public function getUser(){
		$url = 'https://api.github.com/user?'.$this->getAccessTokenQuery();
		$json = file_get_contents($url, false, $this->getStreamContext());
		$jsonObject = json_decode($json);
		
		return $jsonObject;
	}
	public function getEmail(){
		$url = 'https://api.github.com/user/emails?'.$this->getAccessTokenQuery();
		$json = file_get_contents($url, false, $this->getStreamContext());
		$jsonObject = json_decode($json);
		
		return $jsonObject[0]->email;
	}



}