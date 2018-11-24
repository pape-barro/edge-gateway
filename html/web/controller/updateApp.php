<?php
	if(!isset($_SESSION)){ 
		session_start();
	}

	try {
		
		if(isset($_GET["appName"]) && isset($_GET["indexPath"])) {
			$compteur = 0;
			$string="{\"appName\":\"".$_GET["appName"]."\", \"indexPath\":\"".$_GET["indexPath"]."\"},";
			$file = '../utils/app.txt';
			$content = file_get_contents($file);
			$update = str_replace("$string","",$content);
			
			// update the file
			$f = fopen($file, "w+");
			fwrite($f, $update);
			fclose($f);
			$_SESSION ['status']= "Service closed";
		} else {
			$_SESSION ['status']= "Service is busy";
		}
	} catch (Exception $exc) {
		$_SESSION ['status'] = "echec catched";
	}
	header('Location: ../../index.php');
?>
