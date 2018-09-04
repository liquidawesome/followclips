<?php
ini_set('display_errors', 1);
require 'core/init.php';
if (isset($_GET['name']) === true && empty($_GET['name']) === false) {
	$username = htmlspecialchars($_GET['name']);
	
	$user = new User($username);
	
	echo 'ID: ',$user->getId();
	echo '<br/>ID: ',$user->getUsername();
	
	// Process data
	//$id = $rsp['id'];
	//var_dump($rsp);
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