<?php

class GitHubResponseToken {
	private $_accessToken;
	private $_scope;
	private $_type;

	public function __construct($accessToken, $scope, $type){
		$this->_accessToken = $accessToken;
		$this->_scope = $scope;
		$this->_type = $type;
	}

	public function __toString(){
		return $this->_accessToken;
	}
}