<?php
    if(!isset($_SESSION)){ 
        session_start(); 
    }
    if(!isset($_SESSION['current_user'])){
      header('Location: ./login.php');
    }
?>

<!doctype html>
<html lang="en">
	  <head>
		    <meta charset="utf-8">
		    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		    <meta name="description" content="">
		    <meta name="Pape Abdoulaye BARRO" content="">
		    <link rel="icon" href="img/edge.png">
		    <title>Signin</title>
		    <!-- Bootstrap core CSS -->
		    <link href="css/login_bootstrap.css" rel="stylesheet">
		    <!-- Custom styles for this template -->
		    <link href="css/signin.css" rel="stylesheet">
	  </head>
	  <body class="text-center">
		    <form class="form-signin" method="post" action="./controller/pwdController.php">
				<?php
					if (isset($_SESSION['message_user_login_fail'])) {
					echo '<h4 style="text-align: center;">'.$_SESSION['message_user_login_fail'].'</h4>';
					unset($_SESSION['message_user_login_fail']);
					session_destroy();
					}
				?>
		      	<h1 class="h3 mb-3 font-weight-normal"> New Password </h1>
		        <label for="inputOldPassword" class="sr-only">new Password</label>
		        <input type="password" id="inputPassword" name="oldpassword" class="form-control" placeholder="Old Password" required>
		        <label for="inputNewPassword" class="sr-only">new Password</label>
		        <input type="password" id="inputPassword" name="newpassword" class="form-control" placeholder="New Password" required>
		        <button class="btn btn-lg btn-primary btn-block" type="submit"> Update </button>
		    </form>
	  </body>
</html>
