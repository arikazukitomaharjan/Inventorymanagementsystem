<?php
	$_SESSION[ADMINUSER] = '';
	unset($_SESSION[ADMINUSER]);
	
	$mydb->redirect(SITEROOT);
?>