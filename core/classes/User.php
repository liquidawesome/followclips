<?php
class User {
	protected $details;
	
	public function __construct($username) {
		$url = 'https://api.twitch.tv/helix/users?login='.$username;
		
		// Initiate cURL
		$curlUser = curl_init($url);
		
		// Set cURL options
		curl_setopt($curlUser, CURLOPT_HTTPHEADER, array('Client-ID: usc7ke0v80ye96khi6jhia4w61i8yr'));
		curl_setopt($curlUser, CURLOPT_RETURNTRANSFER, true);
		
		// Execute request, decode json response into assoc array
		$rsp = curl_exec($curlUser);
		
		// Get info for debug purposes
		$info = curl_getinfo($curlUser);
		
		// Close cURL connection
		curl_close($curlUser);
		
		$rsp = json_decode($rsp,true);
		//var_dump($rsp);
		
		try {
			if (array_key_exists(0, $rsp['data']) == true) {
				$this->details = $rsp['data'][0];
			} else {
				throw new Exception('User not found.');
			}
		} catch(Exception $e) {
			echo 'Error: ' , $e->getMessage(), '<br/>';
		}
		
	}
	
	public function getId() {
		$id = $this->details['id'];
		return $id;
	}
	
	public function getUsername() {
		$username = $this->details['display_name'];
		return $username;
	}

}