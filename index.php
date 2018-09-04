<?php
ini_set('display_errors', 1);
require 'core/init.php';
if (isset($_GET['name']) === true && empty($_GET['name']) === false) {
	$entered = true;
	$username = htmlspecialchars($_GET['name']);
	
	$user = new User($username);
	
	if ($user->getId() !== null) {
		echo 'ID: ',$user->getUsernameFromId($user->getId());
	}
	
	$user->following();
	
	// Process data
	//$id = $rsp['id'];
	//var_dump($rsp);
} else {
	$entered = false;
}

?>
<html>
<body>
	<h1>Your Followed User Clips</h1>
	<?php if ($entered == false): ?>
	<p>Enter your Twitch.tv username to continue:</p>
	<?php else: ?>
	<p>Welcome, <?php echo $user->getUsernameFromId($user->getId()); ?></p>
	<?php endif; ?>
	<form action="" method="get">
	<input type="text" name="name"/>
	<input type="submit" value="Continue..."/>
	</form>
</body>
</html>