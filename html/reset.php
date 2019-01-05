<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    }
?>
<!doctype html>
<html lang="en">
    <head>
	<title>EDGE-GATEWAY</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="./web/css/bootstrap.min.css">
	<link rel="stylesheet" href="./web/css/bootstrap-responsive.min.css">
	<link rel="stylesheet" href="./web/css/style.css">
	<script src="./web/js/modernizr-2.5.3-respond-1.1.0.min.js"></script>
    </head>
    <body>
	<header id="header" role="banner"><br><h3 style="text-align: center;"> RESET AND REBOOT </h3></header>
	
	<div id="main" class="container" role="main"><br><br>
	      <div class="row first_placeholder">
			<form class="form-signin text-center" method="post" action="./web/data/dataReseter.php">
				<input type="text" name="date" class="form-control" placeholder="YYYY-MM-DD ex: 2018-12-16" style="margin: 5px;  width:23.5%;" required autofocus><br>
				<button style="margin: 5px; width:25%;" class="btn btn-lg btn-primary btn-block" type="submit">RESET</button>
			</form>
	      </div>
	</div>
	
	<span itemprop="copyrightHolder">
	    <!-- /container -->
	    <script src="./web/js/jquery-1.7.1.min.js"></script>
	    <script src="./web/js/bootstrap.min.js"></script>
	    <script src="./web/js/script.js"></script>
	</span>
    </body>
</html>
