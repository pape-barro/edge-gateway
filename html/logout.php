<?php
	if(!isset($_SESSION)){ 
        session_start();
		unset($_SESSION['current_user']);
		$_SESSION['status'] = "Connected";
		session_destroy();
		header('Location: ./index.php');
	}
	
?>
