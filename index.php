<?php
ini_set('display_errors', 1);
require 'core/init.php';
//TODO: isset block should probably be moved to ajax.php. Try not to do much php in index file?
if (isset($_GET['name']) === true && empty($_GET['name']) === false) {
	$entered = true;
	$username = htmlspecialchars($_GET['name']);
	
	$user = new User($username);
	
	//if ($user->getId() !== null) {
	//	echo 'ID: ',$user->getUsernameFromId($user->getId());
	//}
	
	$user->clips();
	
} else {
	$entered = false;
}

?>
<html>
<body>
	<h1>Your Followed User Clips</h1>
	<?php if ($entered == false): ?>
	<p>Enter your Twitch.tv username to continue:</p>
	<form action="" method="get">
	<input type="text" name="name"/>
	<input type="submit" value="Continue..."/>
	</form>
	<?php else: ?>
	<p>Top clips from followed users!</p>
	<?php endif; ?>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="js/actions.js"></script>
</body>
</html>