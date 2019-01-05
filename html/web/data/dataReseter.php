<?php
	if(!isset($_SESSION)){ 
		session_start();
	}

	try {
		if(isset($_POST["date"])) {
			if(preg_match("/^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$/",$_POST["date"])){
				$string="{\"date\":\"".$_POST["date"]."\"}";
				$file = './setup.json';
				// update the file
				$f = fopen($file, "w+");
				fwrite($f, $string);
				fclose($f);
				// execute python scrypt
				exec("python /var/www/html/web/data/data.py");
				$_SESSION ['status']= "Reset succes";
			}else{
				$_SESSION ['status']= "Reset error ";
			}
		} else {
			$_SESSION ['status']= "Reset is busy";
		}
	} catch (Exception $exc) {
		$_SESSION ['status'] = "echec catched";
	}
	header('Location: ../../index.php');
?>
