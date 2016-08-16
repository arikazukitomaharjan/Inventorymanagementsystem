<?php include('includes/header.php');?>

<?php
if(isset($_GET[ADMINACTIONNAME]))
{
	if(file_exists('includes/'.$_GET[ADMINACTIONNAME].".php"))
	{
		include($_GET[ADMINACTIONNAME].".php");
	}
	else
	{
		echo "file doesn't exists.";
	}
}
else
{
	include("includes/dashboard.php");
}
?>

<?php include('includes/footer.php');?>