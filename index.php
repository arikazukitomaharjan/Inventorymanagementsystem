<?php
session_start();
error_reporting(E_ALL);
require_once("classes/call.php");
//echo $mydb->md5_encrypt('654321', SECRETPASSWORD)."<br>";
//print_r($_SESSION);
if(isset($_SESSION[ADMINUSER]))
	$userid = $_SESSION[ADMINUSER];
?>
<?php if(!isset($_SESSION[ADMINUSER]))
{
	include("includes/login.php");
}
else
{
	include("includes/admin.php");
}
?>