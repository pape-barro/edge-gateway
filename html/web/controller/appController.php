<?php
	if(!isset($_SESSION)){ 
		session_start();
	}

	try {
		
		if(isset($_POST["appName"]) && isset($_POST["indexPath"])) {
			$compteur = 0;
			$string="{\"appName\":\"".$_POST["appName"]."\", \"indexPath\":\"".$_POST["indexPath"]."\"},";
			// read and write (r+) into the file
			$file = '../utils/app.txt';
			$f = fopen($file, "a");
			fputs($f, $string);
			fclose($f);
			$_SESSION ['status']= " New Service added";
		} 
	} catch (Exception $exc) {
		$_SESSION ['status'] = "echec catched";
	}
	header('Location: ../../index.php');
?>
