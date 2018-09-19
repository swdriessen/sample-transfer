<?php

class UserRepository extends Repository {





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
			$users[] = $this->constructUser($row);
		}		
		return $users[0] ?? null;
	}
	function fetchGitHubUser($identifier){
		$query = "SELECT * FROM users WHERE identifier='$identifier';";
		$result = $this->query($query);
		$userRows = $this->fetch($result);
		
		$users = [];
		foreach($userRows as $row){
			$users[] = $this->constructUser($row);
		}		
		return $users[0] ?? null;
	}
	function existsGitHubUser($identifier){
		return $this->fetchGitHubUser($identifier) != null;
	}
	function fetchUsers(){
		$query = "SELECT * FROM users;";
		$result = $this->query($query);
		$userRows = $this->fetch($result);
		
		$users = [];		
		foreach($userRows as $row){
			$users[] = $this->constructUser($row);
		}
		return $users;
	}	












	private function constructUser($row){
		return User::constructFromDatabase(
			$row['id'],
			$row['identifier'],
			$row['username'],
			$row['displayname'],
			$row['email'],
			$row['avatar'],
			$row['profile'],
			$row['active']
		);
	}
}