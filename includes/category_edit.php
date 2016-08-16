<script type="text/javascript">
	/* <![CDATA[ */
	jQuery(function(){
		jQuery("#name").validate({
			expression: "if (VAL) return true; else return false;",
			message: "menu name is Mandatory."
		});		
		jQuery('.AdvancedForm').validated(function(){
			alert("Use this call to make AJAX submissions.");
		});
	});
	/* ]]> */
	
</script>
<?php
include("../classes/category.class.php");
include("../classes/createthumbnail.php");
$cid = $_GET['id'];
if (isset($_POST['btnupdate']))
{
	$data="";
	
	$data['name'] = $_POST['name'];
	$data['description'] = $_POST['description'];
	$data['urlcode'] = $mydb->clean4urlcode(trim($_POST['name']));
	
	$mess = $mydb->updateQuery('tbl_category',$data,'id='.$cid);

	$url = ADMINURLPATH."category_add&code=1&message=".$mess;
	$mydb->redirect($url);
}
$rasCat = $mydb->getArray('*','tbl_category','id='.$cid);
?>

<form  name="form1" method="post" action="" enctype="multipart/form-data" id="mainform">
          <table width="100%" cellpadding="0" cellspacing="0" border="0" id="id-form">
    <tr>
      <th>Name:</th>
      <td><input type="text" name="name" id="name" value="<?php echo stripslashes($rasCat['name']); ?>" class="inp-form" /></td>
    </tr>
    <tr class="TitleBarA">
      <th>Description:</th>
      <td><textarea name="description" id="description" cols="" rows="" class="form-textarea"><?php echo stripslashes($rasCat['description']); ?></textarea></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input name="btnupdate" type="submit" value="Update" class="button" onMouseOut="this.className='button'" onMouseOver="this.className='button'" /></td>
    </tr>
  </table>
</form>
