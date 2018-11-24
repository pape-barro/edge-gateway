<?php
	if(!isset($_SESSION)){ 
		session_start(); 
		require_once '../utils/Autoload.php';
		require_once './userController.class.php';
	}


	$result["response"] = "echec";
	$currentUser = unserialize($_SESSION['current_user']);
	$login = $currentUser["login"];
	$pwd = $currentUser["password"];

	try {
		if (!empty($_POST["oldpassword"]) && !empty($_POST["newpassword"])) {
			
			$UserController= new UserController($login, $_POST["oldpassword"]);
			$is_user= $UserController->is_user();
			$response = json_decode($is_user);

			if ($response->{'response'}=="succes"){
				$up = $UserController->updateSecret($_POST["oldpassword"], $_POST["newpassword"]);
				$resp = json_decode($up);
				$_SESSION ['message_user_login_fail']= $resp->{'message'};
				if($resp->{'response'}=="echec"){
					header('Location: ../pwd.php');
				}else{
					header('Location: ../login.php');
				}
				
			}else{
				$_SESSION['message_user_login_fail']= "Identification error!";
				header('Location: ../login.php');
			}
		} else{
			$_SESSION['message_user_login_fail']= $result["response"];
			header('Location: ../login.php');
		}
	} catch (Exception $exc) {
		$_SESSION['message_user_login_fail']= "echec catched";
		header('Location: ../login.php');
	}

