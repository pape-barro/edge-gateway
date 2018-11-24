<?php
    if(!isset($_SESSION)){ 
        session_start();
    }
    if(!isset($_SESSION['current_user'])){
      $_SESSION['message_user_login_fail']= "Session timeout";
      header('Location: ./login.php');
    }
?>

<!doctype html>
<html lang="en">
<head>
<title>EDGE-GATEWAY</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-responsive.min.css">
<link rel="stylesheet" href="css/style.css">
<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
<link rel="icon" href="img/favicon.ico" type="image/x-icon">
<script src="js/modernizr-2.5.3-respond-1.1.0.min.js"></script>
</head>
<body>
<header id="header" role="banner">
  <br>
  <h2 class="btn btn-info btn-sm" style="margin-left: 5%"> <a href="./logout.php">log out</a> </h2>
  <h2 class="btn btn-info btn-sm"> <a href="./pwd.php">new password</a> </h2>
</header>
<div id="main" class="container" role="main">
  <!-- DESC Segment -->
  <div class="row first_placeholder  second_placeholder">
      <h1>Multi-Optional Setting Interface (MOSI)</h1><hr>
      <?php
			    if (isset($_SESSION['message'])) {
            echo '<h4 style="text-align: center;">'.$_SESSION['message'].'</h4>';
            unset($_SESSION['message']);
			    }
			?>
        <section class="span12">
           <div id="demo" class="well collapsible_box">
              <br>
              <fieldset>
               <?php
                  $file = '/opt/edge-gateway/global_conf.json';
                  $log = json_decode(file_get_contents("$file"));
                  if(isset($log->{"gateway_conf"}->{"servers"}[2]->{"address"})){
                    if($log->{"gateway_conf"}->{"servers"}[2]->{"address"}=="router.eu.thethings.network"){
                      echo '<ul class="btn btn-lg btn-success" style="width:80%;"><li><i class="icon-star"></i> the things network is running</li></ul>';
                    }
                  }
                  if(isset($log->{"gateway_conf"}->{"servers"}[1]->{"address"})){
                    if($log->{"gateway_conf"}->{"servers"}[1]->{"address"}=="router.eu.thethings.network"){
                      echo '<ul class="btn btn-lg btn-success" style="width:80%;"><li><i class="icon-star"></i> the things network is running </li></ul>';
                    }elseif($log->{"gateway_conf"}->{"servers"}[1]->{"address"}!=""){
                      echo '<ul class="btn btn-lg btn-success" style="width:80%;"><li><i class="icon-star"></i> local community network is running on :'.$log->{"gateway_conf"}->{"servers"}[1]->{"address"}.'</li></ul>';
                    }
                  }
                  if(isset($log->{"gateway_conf"}->{"servers"}[0]->{"address"})){
                    if($log->{"gateway_conf"}->{"servers"}[0]->{"address"}=="localhost"){
                      echo '<ul class="btn btn-lg btn-success" style="width:80%;"><li><i class="icon-star"></i> Isolated Gateway is running</li></ul>';
                    }elseif($log->{"gateway_conf"}->{"servers"}[0]->{"address"}=="router.eu.thethings.network"){
                      echo '<ul class="btn btn-lg btn-success" style="width:80%;"><li><i class="icon-star"></i> the things network is running </li></ul>';
                    }elseif($log->{"gateway_conf"}->{"servers"}[0]->{"address"}!=""){
                      echo '<ul class="btn btn-lg btn-success" style="width:80%;"><li><i class="icon-star"></i> local community network is running on :'.$log->{"gateway_conf"}->{"servers"}[0]->{"address"}.'</li></ul>';
                    }
                  }
              ?>
              </fieldset>'
              <hr/>
              <form method="post" action="./controller/global_configController.php">
                  <h1> <input type="checkbox" name="ttn"/> &nbsp;&nbsp; THE THINK NETWORK COMMUNITY (Optional)</h1>
                  <h1><input type="checkbox" name="isolgate"/> &nbsp;&nbsp;&nbsp;&nbsp; ISOLATED GATEWAY (Optional)</h1>
                  <h1><input type="checkbox" name="lcn"/> &nbsp;&nbsp; LOCAL COMMUNITY NETWORK (LCN)(Optional)</h1>
                  <fieldset>
                    <label class="big">If you choose L.C.N., you have to add :</label>
                    <input type="text" class="span5" name="ip" placeholder="LOCAL SERVER IP ADDRESS"><br/>
                  </fieldset>
                  <button type="submit" class="btn btn-lg"> UPDATE </button>
              </form>
          </div>
      </section>
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
<script src="js/jquery-1.7.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/script.js"></script>
</span>
</body>
</html>
