<?php
/************************************************************
 * SuperAdmin Admin panel									*
 * Copyright (c) 2012 ARK Infotec								*
 * www.arkinfotec.com											*
 *															*
 ************************************************************/
 
$isLoginPage = true; 
define('USER_SESSION_NOT_REQUIRED', true);
include("includes/app.php");

if(!empty($_POST['email']) && !empty($_POST['password'])){
	userLogin($_POST);
}
elseif(!empty($_GET['logout'])){
	userLogout(true);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex">
<title>SuperAdmin</title>
<!-- BEGIN CORE CSS FRAMEWORK -->
<link href="assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="assets/plugins/boostrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="assets/plugins/boostrapv3/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
<link href="assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
<link href="assets/css/animate.min.css" rel="stylesheet" type="text/css"/>
<!-- END CORE CSS FRAMEWORK -->
<!-- BEGIN CSS TEMPLATE -->
<link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
<link href="assets/css/responsive.css" rel="stylesheet" type="text/css"/>
<link href="assets/css/custom-icon-set.css" rel="stylesheet" type="text/css"/>
<!-- END CSS TEMPLATE -->
</head>
<body class="error-body no-top">
<div class="container">
  <div class="row login-container column-seperation">  
        <div class="col-md-5 col-md-offset-1">
          <h2>Sign in to WP Multi Admin</h2>
          <p>For manage multi wordpress sites from a Admin Panel..</p>
          <br />
          
          <?php if(!empty($_SESSION['errorMsg'])){ ?>
            <div class="errorMsg"><?php echo $_SESSION['errorMsg'];  unset($_SESSION['errorMsg']); ?></div>
            <?php } ?>
            <?php if(!empty($_SESSION['successMsg'])){ ?>
            <div class="successMsg"><?php echo $_SESSION['successMsg'];  unset($_SESSION['successMsg']); ?></div>
        <?php } ?>
        </div>

        <div class="col-md-5 "> <br>
		 <form id="login-form" class="login-form" action="login.php" method="post">
		 <div class="row">
		 <div class="form-group col-md-10">
            <label class="form-label">Username</label>
            <div class="controls">
				<div class="input-with-icon  right">                                       
					<i class=""></i>
<input type="text" name="email" class="loginOnEnter form-control" value="Email" id="email"  onfocus="if(this.value=='Email'){this.value=''; this.style.color='#676c70';}  else { this.style.color='#676c70'; };" onblur="if(this.value==''){ this.value='Email'; this.style.color='#adafb2';}" style="color: #adafb2; "/>                                        
				</div>
            </div>
          </div>
          </div>
		  <div class="row">
          <div class="form-group col-md-10">
            <label class="form-label">Password</label>
            <span class="help"></span>
            <div class="controls">
				<div class="input-with-icon  right">                                       
					<i class=""></i>
<input type="password" name="password" class="loginOnEnter form-control" value="Password" id="password" onfocus="if(this.value=='Password'){this.value=''; this.style.color='#676c70';}  else { this.style.color='#676c70'; };" onblur="if(this.value==''){ this.value='Password'; this.style.color='#adafb2';}" style="color: #adafb2; "/>
                                            
				</div>
            </div>
          </div>
          </div>
		  <div class="row">
<!--          <div class="control-group  col-md-10">
            <div class="checkbox checkbox check-success"> <a href="#">Trouble login in?</a>&nbsp;&nbsp;
              <input type="checkbox" id="checkbox1" value="1">
              <label for="checkbox1">Keep me reminded </label>
            </div>
          </div>-->
          </div>
          <div class="row">
            <div class="col-md-10">
              <button class="btn btn-primary btn-cons pull-right"  name="loginSubmit" type="submit">Login</button>
            </div>
          </div>
		  </form>
        </div>
     
    
  </div>
</div>
<!-- END CONTAINER -->
<!-- BEGIN CORE JS FRAMEWORK-->
<script src="assets/plugins/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/plugins/pace/pace.min.js" type="text/javascript"></script>
<script src="assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="assets/js/login.js" type="text/javascript"></script>
<!-- BEGIN CORE TEMPLATE JS -->
<!-- END CORE TEMPLATE JS -->
</body>    
    
    
<body>
<div class="signin_cont">
<form action="login.php" method="post" name="loginForm">
<div id="logo_signin">Multi Admin</div>
<div class="copy">Sign In to manage your WordPress sites</div>
<?php if(!empty($_SESSION['errorMsg'])){ ?>
<div class="errorMsg"><?php echo $_SESSION['errorMsg'];  unset($_SESSION['errorMsg']); ?></div>
<?php } ?>
<?php if(!empty($_SESSION['successMsg'])){ ?>
<div class="successMsg"><?php echo $_SESSION['successMsg'];  unset($_SESSION['successMsg']); ?></div>
<?php } ?>
<input type="text" name="email" class="loginOnEnter" value="Email" id="email"  onfocus="if(this.value=='Email'){this.value=''; this.style.color='#676c70';}  else { this.style.color='#676c70'; };" onblur="if(this.value==''){ this.value='Email'; this.style.color='#adafb2';}" style="color: #adafb2; "/>
<input type="password" name="password" class="loginOnEnter" value="Password" id="password" onfocus="if(this.value=='Password'){this.value=''; this.style.color='#676c70';}  else { this.style.color='#676c70'; };" onblur="if(this.value==''){ this.value='Password'; this.style.color='#adafb2';}" style="color: #adafb2; "/>
<input type="submit" id="loginSubmitBtn" style="display:none;" name="loginSubmit" value="submit" />
<div class="btn"><a class="rep_sprite" id="loginBtn" onclick="$('#loginSubmitBtn').click();">Log in</a></div>
</form>
</div>
</body>
</html>