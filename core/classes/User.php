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
		//$info = curl_getinfo($curlUser);
		
		// Close cURL connection
		curl_close($curlUser);
		
		$rsp = json_decode($rsp,true);
		
		// TODO: Don't display PHP error when user is not found.
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
	
	public function getUsernameFromId($id) {
		$url = 'https://api.twitch.tv/helix/users?id='.$id;
		
		// Initiate cURL
		$ch = curl_init($url);
		
		// Set cURL options
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Client-ID: usc7ke0v80ye96khi6jhia4w61i8yr'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		// Execute request
		$rsp = curl_exec($ch);
		
		// Close cURL connection
		curl_close($ch);
		// Decode json response into assoc array
		$rsp = json_decode($rsp,true);
		return $rsp['data'][0]['display_name'];
	}
	
	public function clips() {
		$id = $this->getId();
		$after = '';
		$users = array();
		do {
			$url = 'https://api.twitch.tv/helix/users/follows?from_id='.$id.'&first=100&after='.$after;
			
			// Initiate cURL
			$ch = curl_init($url);
			
			// Set cURL options
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Client-ID: usc7ke0v80ye96khi6jhia4w61i8yr'));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, 1);
			
			// Execute request, decode json response into assoc array
			$rsp = curl_exec($ch);
			
			// Get info for debug purposes
			//$info = curl_getinfo($ch);
			
			// Close cURL connection
			curl_close($ch);
			
			/* Grabbing full header may not be necessary, but this dowhile loop has many queries of Twitch API that
			 * can trigger the API Ratelimit. This is not good. Ratelimit header information is found in $rspHead as
			 * Ratelimit-Limit, Ratelimit-Remaining, and Ratelimit-Reset
			 * See: https://dev.twitch.tv/docs/api/guide/
			 */
			$rspFull = explode("\r\n\r\n",$rsp);
			$rspHead = explode("\r\n",$rspFull[0]);
			$rsp = $rspFull[1];
			$rsp = json_decode($rsp,true);
			
			foreach($rsp['data'] as $follow) {
				$users[] = $follow['to_id'];
				//echo '<br/>',$follow['to_id'];
			}
			
			$after = $rsp['pagination']['cursor'];
			
		} while(!empty($rsp['data']));
		
		foreach($users as $user) {
			$url = 'https://api.twitch.tv/helix/clips?broadcaster_id='.$user.'&after='.$after;
			
			// Initiate cURL
			$ch = curl_init($url);
			
			// Set cURL options
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Client-ID: usc7ke0v80ye96khi6jhia4w61i8yr'));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			
			// Execute request
			$rsp = curl_exec($ch);
			
			// Get info for debug purposes
			//$info = curl_getinfo($ch);
			
			// Close cURL connection
			curl_close($ch);
			// Decode json response into assoc array
			$rsp = json_decode($rsp,true);
			var_dump($rsp);
			break;
		}
		
	}

}