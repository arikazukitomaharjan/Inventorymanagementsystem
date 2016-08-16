<?php
if(isset($_POST['username']))
{
	$getpass 		= $mydb->CleanString($_POST['password']);
	$getusername 	= $mydb->CleanString($_POST['username']);
	//print_r($_POST);
	
	if($mydb->count_row($mydb->getQuery("*","tbl_admin","username = '".$getusername."'")) == 1)
	{
		$dbpass = $mydb->md5_decrypt($mydb->getValue("pass","tbl_admin","username = '".$getusername."'"), SECRETPASSWORD);
/*		echo $dbpass;
		die();*/
		if($dbpass == $getpass)
		{
			$_SESSION[ADMINUSER] = $mydb->getValue("id","tbl_admin","username = '".$getusername."'");
			
			$redirectUrl = SITEROOT.'index.php';
			$querystring = $_SERVER['QUERY_STRING'];
			if(!empty($querystring))
				$redirectUrl = $redirectUrl.'?'.$querystring;
			$mydb->redirect($redirectUrl);
		}
		else
		{
				echo "no";
		}
	}
	else
		$alertmessage = '<div id="message-red" style="text-align:center; padding-left: 37px;">
				<table border="0" width="90%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="red-left">Error! Invalid Username/Password Combination</a></td>
					<td class="red-right"><a class="close-red"><img src="images/table/icon_close_red.gif"   alt="" /></a></td>
				</tr>
				</table>
				</div>';
	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Inventory Management System :: Administrator Login</title>
<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" title="default" />
<!--  jquery core -->
<script src="js/jquery/jquery-1.4.1.min.js" type="text/javascript"></script>

<!-- Custom jquery scripts -->
<script src="js/jquery/custom_jquery.js" type="text/javascript"></script>

<!-- MUST BE THE LAST SCRIPT IN <HEAD></HEAD></HEAD> png fix -->
<script src="js/jquery/jquery.pngFix.pack.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
$(document).pngFix( );
});
</script>
</head>
<body id="login-bg"> 
 
<!-- Start: login-holder -->
<div id="login-holder">

	<!-- start logo -->
	<div id="logo-login">
		<a href="index.html"><img src="images/shared/logo.png" width="156" height="40" alt="" /></a>
	</div>
	<!-- end logo -->
	
	<div class="clear"></div>
	
	<!--  start loginbox ................................................................................. -->
	<div id="loginbox">
	
		<!--  start message -->
		<?php if(isset($alertmessage)) echo $alertmessage;?>
        <!--  end message -->
	<!--  start login-inner -->
	<div id="login-inner">
        <form action="" method="post" name="frmLogin">
        <table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<th>Username</th>
			<td><input name="username" id="username" type="text"  class="login-inp" value="guest" /></td>
		</tr>
		<tr>
			<th>Password</th>
			<td><input name="password" id="password" type="password" value="guest"  onfocus="this.value=''" class="login-inp" /></td>
		</tr>

		<tr>
			<th></th>
			<td><input name="btnLogin" type="submit" class="submit-login" value="Login"  /></td>
		</tr>
		<tr>
		  <td colspan="2">You just need to click on submit to login</td>
		  </tr>
		</table>
        </form>
	</div>
 	<!--  end login-inner -->
	<div class="clear"></div>
	<!--<a href="" class="forgot-pwd">Forgot Password?</a>-->
 </div>
 <!--  end loginbox -->
 
	<!--  start forgotbox ................................................................................... -->
	<div id="forgotbox">
		<div id="forgotbox-text">Please send us your email and we'll reset your password.</div>
		<!--  start forgot-inner -->
		<div id="forgot-inner">
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<th>Email address:</th>
			<td><input type="text" value=""   class="login-inp" /></td>
		</tr>
		<tr>
			<th> </th>
			<td><input type="button" class="submit-login"  /></td>
		</tr>
		</table>
		</div>
		<!--  end forgot-inner -->
		<div class="clear"></div>
		<a href="" class="back-login">Back to login</a>
	</div>
	<!--  end forgotbox -->

</div>
<!-- End: login-holder -->
</body>
</html>