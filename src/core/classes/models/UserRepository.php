<?php

class UserRepository extends Repository
{
	public function create($user)
	{		
		$active = $user->active ? 1 : 0;

		$query = "INSERT INTO users(`identifier`, `username`, `displayname`, `email`, `avatar`, `profile`, `active`) ";
		$query.= "VALUES ('$user->identifier','$user->username','$user->displayname','$user->email','$user->avatar','$user->profile', '$active');";
		
		$result = $this->query($query);

		return $this->_connection->insert_id;
	}

	
	function fetchUser($id){
		$query = "SELECT * FROM users WHERE id='$id';";
		$result = $this->query($query);
		$userRows = $this->fetch($result);
		//Utilities::dump($query);
		$users = [];
		
		foreach($userRows as $row){

			$user = new User();
			$user->id = $row['id'];
			$user->identifier = $row['identifier'];
			$user->username = $row['username'];
			$user->displayname = $row['displayname'];
			$user->email = $row['email'];
			$user->avatar = $row['avatar'];
			$user->profile = $row['profile'];
			$user->active =  $row['active'];

			$users[] = $user;
		}
		
		return $users[0] ?? null;
	}
	function fetchGitHubUser($identifier){
		$query = "SELECT * FROM users WHERE identifier='$identifier';";
		$result = $this->query($query);
		$userRows = $this->fetch($result);
		
		$users = [];
		foreach($userRows as $row){
			$user = new User();

			$user->id = $row['id'];
			$user->identifier = $row['identifier'];
			$user->username = $row['username'];
			$user->displayname = $row['displayname'];
			$user->email = $row['email'];
			$user->avatar = $row['avatar'];
			$user->profile = $row['profile'];
			$user->active =  $row['active'];

			$users[] = $user;
		}
		
		if(count($users)==1){
			return $users[0];
		}
		return null;
	}
	function existsGitHubUser($identifier){
		return $this->fetchGitHubUser($identifier) !=  null;
	}
	function fetchUsers(){
		$query = "SELECT * FROM users;";
		$result = $this->query($query);
		$userRows = $this->fetch($result);
		
		$users = [];
		
		foreach($userRows as $row){

			$user = new User();
			$user->id = $row['id'];
			$user->identifier = $row['identifier'];
			$user->username = $row['username'];
			$user->displayname = $row['displayname'];
			$user->email = $row['email'];
			$user->avatar = $row['avatar'];
			$user->profile = $row['profile'];
			$user->active =  $row['active'];

			$users[] = $user;
		}

		return $users;
	}	
}