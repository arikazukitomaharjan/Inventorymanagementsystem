<?php
if($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['HTTP_HOST']=="localhost")
{
	define("DBSERVER","localhost");
	define("DBUSER","sabin");
	define("DBPASSW",'sabin2012');
	define("DBNAME","digitala_ims");
}
else
{

	define("DBSERVER","localhost");
	define("DBUSER","digitala_imsuser");
	define("DBPASSW",'WC[)a(Dl-DTU');
	define("DBNAME","digitala_ims");
}

?>
