<?php
class User {
	protected $id, $username, $user;
	
	public function __construct($username) {
		$this->username = htmlspecialchars($username);
		$url = 'https://api.twitch.tv/helix/users?login='.$username;
		

	}

}