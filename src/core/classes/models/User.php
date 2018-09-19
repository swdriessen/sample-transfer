<?php

class User 
{
	public $id;	
	public $identifier;
	public $username;
	public $displayname;
	public $email;
	public $avatar;
	public $profile;
	public $active;

	public function __construct(){
		$this->id = 0;
		$this->identifier = 0;
		$this->username = '';
		$this->displayname = '';
		$this->email = '';
		$this->avatar = '';
		$this->profile = '';
		$this->active = 0;
	}

	public static function constructFromDatabase($id, $identifier, $username, $displayname, $email, $avatar, $profile, $active){
		$instance = new self();
		
		$instance->id = $id;
		$instance->identifier = $identifier;
		$instance->username = $username;
		$instance->displayname = $displayname;
		$instance->email = $email;
		$instance->avatar = $avatar;
		$instance->profile = $profile;
		$instance->active = $active;

		return $instance;
	}

}
