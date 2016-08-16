<?php
if(isset($_GET['manager']))
{
	$pagename = $_GET['manager'];
	if($pagename=='category_manage')
		$pagetitle = "Inventory";
	else if($pagename=='category_add')
		$pagetitle = "Add Category";
	else if($pagename=='category_edit')
		$pagetitle = "Category Edit";
	else if($pagename=='inventory')
		$pagetitle = "Inventory";
	else if($pagename=='salesView')
		$pagetitle = "Report";
	else if($pagename=='report')
		$pagetitle = "Report";
	else if($pagename=='search')
		$pagetitle = "Search Result";
	else if($pagename=='change_password')
		$pagetitle = "Change Password";
	else if($pagename=='product_manage')
	{
		if(isset($_GET['id']))
		{
			$pid = $_GET['id'];
			$pagetitle = "Update Product";
			$do = "Update";
		}
		else
		{
			$pid = 0;			
			$pagetitle = "Add Product";
			$do = "Add";
		}
	}
	else if($pagename=='logout')
		$pagetitle = "Logout . . .";
		
}
else
{
	$pagetitle = "Dashboard";
}
?>