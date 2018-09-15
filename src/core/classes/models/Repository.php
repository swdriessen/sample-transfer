<?php

abstract class Repository {
	protected $_connection;

	public function __construct($connection){
		$this->_connection = $connection;
	}

	public function query($query){
		return mysqli_query($this->_connection, $query);
	}

	public function fetch($result){
		$rows = [];

		while($row = mysqli_fetch_assoc($result)){
			$rows[] = $row;
		}

		return $rows;
	}

	public function close(){
		mysqli_close($this->_connection);
	}
}