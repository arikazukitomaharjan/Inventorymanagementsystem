<?php
// client
define("ACTIONNAME","manager");
define("URLPATH","index.php?".ACTIONNAME."=");
if($_SERVER['HTTP_HOST'] =='localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1')
{
	define("SITEROOT","http://localhost/ims/");
	define("SITEROOTADMIN","http://localhost/ims/dacadmin/");
	define("SITEROOTDOC",$_SERVER['DOCUMENT_ROOT']."/ims/");
}
else
{
	define("SITEROOT","http://digitalagencycatmandu.com/external/ims/");
	define("SITEROOTDOC",$_SERVER['DOCUMENT_ROOT']."/external/ims/");
}

define("FILEPATH","includes/");
define("PAGING","dashboard/");
define("IMAGEPATH","images/");

define("USERID","sanjeevdbclientuser");

$allowedimageext = array ("jpg", "jpeg", "gif", "png");

$allowedextfile = array ("pdf", "doc", "docx", "txt", "xls");



// admin
define("PRODUCTIMAGEPATH","images/product/");
define("PRODUCTTHUMBPATH","images/product/thumb/");

define("ADMINACTIONNAME","manager");
define("ADMINURLPATH","index.php?".ADMINACTIONNAME."=");
define("ADMINUSER","sanjeevdbdfg546gfddgdfg");
define("SECRETPASSWORD","sanjeevsinghdbementendc");

?>
