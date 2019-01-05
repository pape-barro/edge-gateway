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
	<header id="header" role="banner"><br>
	    <?php 
			if(isset($_SESSION['current_user'])){
				echo'
					<form class="form-signin text-center" method="post" action="./web/controller/appController.php">
						<input type="text" name="appName" class="form-control" placeholder="Application name" style="margin: 5px;" required autofocus>
						<input type="text" name="indexPath" class="form-control" placeholder="./MyApp/index.html" style="margin: 5px;" required autofocus>
						<button style="margin: 5px;" class="btn btn-lg btn-primary btn-block" type="submit">Add service</button>
					</form>
				';
				echo'<div></div><h2 class="btn btn-info btn-sm"> <a href="./logout.php">log out</a> </h2>';
				echo'<h2 class="btn btn-danger btn-sm"> <a href="./reset.php">reset</a> </h2></div>';
				echo '<h1 style="text-align: center; color: green;"><span class="btn btn-lg btn-info" style="width:50%;">Add yourApp on "/var/www/html/" and added here as a service</span></h1>';
			}else{
				echo'<h2 class="btn btn-info btn-sm" style="margin-left: 95%"> <a href="./login.php">log in</a> </h2>';
			}
	    ?>
	</header>
	
	<div id="main" class="container" role="main">
	      <div class="row first_placeholder">
		    <?php
		    if(isset($_SESSION['status'])) {
			    echo '<h1 style="text-align: center; color: green;"><span class="btn btn-lg btn-success" style="width:80%;">'.$_SESSION['status'].'</span></h1>';
			    unset($_SESSION['status']);
			}
			echo '<h1> Available services (Click on):</h1><hr><br><br><br>';
			$string="{\"appName\":\"appName\", \"indexPath\":\"indexPath\"}";
			$file = file_get_contents("./web/utils/app.txt");
			$datas = "[".$file."".$string."]";
			$objects = json_decode($datas);
			
			foreach ($objects as $obj) {
			    if($obj->{'indexPath'}!="indexPath" && $obj->{'appName'}!="appName"){
					echo '<section class="span4">';
					if(isset($_SESSION['current_user'])){
						echo '<a class="close" href="./web/controller/updateApp.php?appName='.$obj->{'appName'}.'&indexPath='.$obj->{'indexPath'}.'">&times;</a>';
					}
					echo '<a href="'.$obj->{'indexPath'}.'"><h3 class="featured_one">'.$obj->{'appName'}.'</h3></a></section>';
			    }
			}
		    ?>
	      </div>
	      <br><br><br>
	      <!-- Footer Segment -->
	      <footer id="footer" class="footer">
			<h1 class="visuallyhidden" itemprop="name">Edge gateway for multiples options</h1>
			<p class="pull-right"> <a id="onTop" href="#main">Back to top</a> </p>
			<p class="credit"><span itemprop="copyrightHolder"> Copyright &copy; <a itemprop href="#"><span itemprop="name">T/ICT4D LAB - ICTP (Italie)</span></a> <span itemprop="copyrightYear">2018-2019</span></span></p>
			<p itemprop="author">Powered By <a target="_blank" href="#"><span itemprop="name">Pape Abdoulaye BARRO</span></a></p>
	      </footer>
	</div>
	
	<span itemprop="copyrightHolder">
	    <!-- /container -->
	    <script src="./web/js/jquery-1.7.1.min.js"></script>
	    <script src="./web/js/bootstrap.min.js"></script>
	    <script src="./web/js/script.js"></script>
	</span>
    </body>
</html>
