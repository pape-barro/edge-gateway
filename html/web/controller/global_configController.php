<?php
	if(!isset($_SESSION)){ 
		session_start(); 
		require_once '../utils/Autoload.php';
		require_once './userController.class.php';
	}
	
	if(!isset($_SESSION['current_user'])){
	  $_SESSION['message_user_login_fail']= "Session timeout";
      header('Location: ../login.php');
    }

	try {
		if (!empty($_POST["ttn"]) || !empty($_POST["lcn"])  || !empty($_POST["isolgate"])  || !empty($_POST["ip"])) {
			$begin = "{\"SX127x_conf\":{\"freq\": 868300000,\"spread_factor\": 7,\"pin_nss\": 11,\"pin_dio0\": 27,\"pin_rst\": 0,\"pin_led1\":4,\"pin_NetworkLED\": 22,\"pin_InternetLED\": 23,\"pin_ActivityLED_1\": 29},\"gateway_conf\":{\"ref_latitude\": 0.0,\"ref_longitude\": 0.0,\"ref_altitude\": 10,\"name\": \"Edge Gateway\",\"email\": \"pape.abdoulaye.barro@gmail.com\",\"desc\": \"a multi-service gateway for communities\",\"servers\":[";
			$end = "]}}";
			$ttn = "";
			$lcn = "";
			$isolgate = "";
			if(isset($_POST["ttn"])){
				if($_POST["ttn"]=="on"){
					$ttn = "{\"address\": \"router.eu.thethings.network\",\"port\": 1700,\"enabled\": true}";
				}
			}
			
			if(isset($_POST["lcn"])){
				if($_POST["lcn"]=="on"){
					if(isset($_POST["ip"])){
						if(preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/', $_POST["ip"])){
							if($ttn!=""){
								$lcn = "{\"address\": \"".$_POST["ip"]."\",\"port\": 1700,\"enabled\": true},";
							}else{
								$lcn = "{\"address\": \"".$_POST["ip"]."\",\"port\": 1700,\"enabled\": true}";
							}
						}else{
								$_SESSION['message']= "Error! the IP address format is not correct";
								header('Location: ../index.php');
						}
					}
				}
			}
			
			if(isset($_POST["isolgate"])){
				if($_POST["isolgate"]=="on"){
					if($ttn!="" || $lcn !=""){
						$isolgate = "{\"address\": \"localhost\",\"port\": 1700,\"enabled\": true},";
					}else{
						$isolgate = "{\"address\": \"localhost\",\"port\": 1700,\"enabled\": true}";
					}
				}
			}
			
			if($ttn=="" && $lcn=="" && $isolgate==""){
				$isolgate = "{\"address\": \"localhost\",\"port\": 1700,\"enabled\": true}";
			}
			
			$string = $begin.$isolgate.$lcn.$ttn.$end;
			// write on the file
			$file = '/opt/edge-gateway/global_conf.json';
			$f = fopen($file, 'w+');
			fwrite($f, $string);
			fclose($f);
			$log = json_decode(file_get_contents("$file"));
			if($_POST["ttn"]=="on"){
				if($log->{"gateway_conf"}->{"servers"}[2]->{"address"}=="router.eu.thethings.network" || $log->{"gateway_conf"}->{"servers"}[0]->{"address"}=="router.eu.thethings.network"){
					$_SESSION['message']= "updated successfully";
				}
			}elseif($_POST["lcn"]=="on"){
				if($lcn!=""){
					if($log->{"gateway_conf"}->{"servers"}[1]->{"address"}!="" || $log->{"gateway_conf"}->{"servers"}[0]->{"address"}!=""){
						$_SESSION['message']= "updated successfully";
					}
				}
			}elseif($_POST["isolgate"]=="on"){
				if($log->{"gateway_conf"}->{"servers"}[0]->{"address"}=="localhost"){
					$_SESSION['message']= "updated successfully";
				}
			}else{
				$_SESSION['message']= "no update";
			}
			
			header('Location: ../index.php');
		} else{
			$_SESSION['message']= "Not updated";
			header('Location: ../index.php');
		}
	} catch (Exception $exc) {
		$_SESSION['message']= "echec catched";
		header('Location: ../index.php');
	}

