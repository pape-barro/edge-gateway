<?php
header('Content-Type: application/json');
if(!isset($_SESSION)){ 
        session_start(); 
        require_once '../utils/Autoload.php';
    }

class UserController {
    private $login;
    private $password;
            
    function __construct($login,$password) {
        $this->login = $login;
        $this->password =md5(sha1(md5(sha1(md5($password))))); 
        $_SESSION['login'] = $login;
        $_SESSION['password'] = $password;
    }
    
    public static function encript($password){
        return md5(sha1(md5(sha1(md5($password)))));
    }

    function is_user(){
        $getUser= array();
        $response = array();
        $response['response'] ="echec";
        //$password= md5(sha1(md5(sha1(md5($this->password)))));
        $log = json_decode(file_get_contents("../utils/log.json"));
        if($log->{'login'}==$this->login && $log->{'password'}==$this->password){
            $getUser["login"] = $log->{'login'};
            $getUser["password"] = $log->{'password'};
            $_SESSION['current_user'] = serialize($getUser);
            $response['response'] = "succes";
        }
        return json_encode($response);
    }
    
    public static function updateSecret($ancien, $secret){
        $result["response"] = "echec";
        $currentUser = unserialize($_SESSION['current_user']);
        if(isset($_SESSION['current_user'])){
            $ancien = md5(sha1(md5(sha1(md5($ancien)))));
            $secret = md5(sha1(md5(sha1(md5($secret)))));
            $ancienSecret = $currentUser['password'];
            if($ancienSecret==$ancien){
                $string="{\"login\":\"".$currentUser['login']."\", \"password\":\"".$secret."\"}";
                // write into the file
                $file = '../utils/log.json';
                $f = fopen($file, 'w+');
                fwrite($f, $string);
                fclose($f);
                $log = json_decode(file_get_contents("../utils/log.json"));
                if($log->{'password'}==$currentUser['password']){
                    $result['message']="Password not updated, please try again";
                }else{
                    $result["response"] = "succes";
                    $result['message']="Password updated successfully";
                }
            }  else {
                $result['message']="The old password is Incorrect, please try again";
            }
        }  else {
            $result['message']="Identify yourself first";
        }
        return json_encode($result);
    }

}

//$login = "pape";
//$pwd = "pape";
//$UserController = new UserController($login, $pwd);

//printf("\n".$pwd."\n");
//$pass = $UserController->encript($pwd);
//$log = json_decode(file_get_contents("../utils/log.json"));

//if($log->{'password'}==$pass){
//    print('ok');
//}

// {"login":"admin","password":"4a80785e7336ee978c90b69566ff0bd8"}




