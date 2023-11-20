<!-- This code to sign out -->
<?php
// the session starter
	session_start();
	// the function to exit
	session_destroy();
	// return to main page 
	header("Location: main.php");
?>