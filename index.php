<?php
require 'core/init.php';
if (isset($_GET['name']) === true && empty($_GET['name']) === false) {
	$username = htmlspecialchars($_GET['name']);
	
	$url = 'https://api.twitch.tv/helix/users?login='.$username;
	
	// Initiate cURL
	$curlUser = curl_init($url);
	
	// Set cURL options
	curl_setopt($curlUser, CURLOPT_HTTPHEADER, array('Client-ID: usc7ke0v80ye96khi6jhia4w61i8yr'));
	curl_setopt($curlUser, CURLOPT_RETURNTRANSFER, true);
	
	// Execute request, decode json response into assoc
	$rsp = curl_exec($curlUser);
	$rsp = json_decode($rsp,true);
	
	// Get info for debug purposes
	$info = curl_getinfo($curlUser);

	// Close cURL connection
	curl_close($curlUser);

	// Process data
	$id = $rsp['data'][0]['id'];
	var_dump($rsp);
}

?>
<html>
<body>
	<h1>Your Followed User Clips</h1>
	<p>Enter your Twitch.tv username to continue:</p>
	<form action="" method="get">
	<input type="text" name="name"/>
	<input type="submit" value="Continue..."/>
	</form>
</body>
</html>