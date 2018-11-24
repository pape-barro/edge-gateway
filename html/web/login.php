<?php
	unset($_SESSION['current_user']);
	if(!isset($_SESSION)){
	    session_start();
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
		    <form class="form-signin" method="post" action="./controller/loginController.php">
		      	<?php
			    if (isset($_SESSION['message_user_login_fail'])) {
				echo '<h4 style="text-align: center;">'.$_SESSION['message_user_login_fail'].'</h4>';
				unset($_SESSION['message_user_login_fail']);
				session_destroy();
			    }else{
				    echo '<h1 class="h3 mb-3 font-weight-normal"> Edge gateway </h1>';
			    }
			?>
		        <label for="inputEmail" class="sr-only">Login</label>
		        <input type="text" id="inputEmail" name="login" class="form-control" placeholder="Login" required autofocus>
		        <label for="inputPassword" class="sr-only">Password</label>
		        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
		        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
		    </form>
	  </body>
</html>
