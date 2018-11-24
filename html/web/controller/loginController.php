<?php
//header('Content-Type: application/json');
if(!isset($_SESSION)){ 
    session_start(); 
    require_once '../utils/Autoload.php';
    require_once './userController.class.php';
}


$result["response"] = "echec";
try {
    if (!empty($_POST["login"])) {
        $login = str_replace('=', '', str_replace(' or ', '', htmlspecialchars($_POST["login"])));
        if(isset($_POST["password"])){
           $pwd = $_POST["password"]; 
        }  else {
            $pwd = ""; 
        }
        /*************************  ************************/
        $UserController= new UserController($login, $pwd);
        $is_user= $UserController->is_user();
        $response = json_decode($is_user);

        if ($response->{'response'}=="succes"){
            $_SESSION ['status']= $response->{'response'};
            header('Location: ../index.php');
        }else{
            $_SESSION['message_user_login_fail']= "Authentication error!";
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



   
