<?php
$user_id = $_SESSION[ADMINUSER];	
$rasUser=$mydb->getArray('*','tbl_admin','id='.$user_id);	   

if(isset($_POST['btnChange']))
{
	$old_password = $_POST['old_password'];
	$db_password = $mydb->md5_decrypt($rasUser['pass'],SECRETPASSWORD);
	if($old_password==$db_password)
	{
		$new_password = $_POST['new_password'];
		$conf_password = $_POST['conf_password'];
		if($new_password==$conf_password)
		{
		$data = '';
		$data['pass'] = $mydb->md5_encrypt($new_password,SECRETPASSWORD);
		$mydb->updateQuery('tbl_admin',$data,'id='.$user_id);
			$code = 1;				
			$message="Your password has been changed.";
		}
		else
		{
			$message="Password confirmation failed.";				
		}
	}
	else
	{
		$message="Old password doesnot match";
	}
}

if(isset($message))
{
	if(isset($code) && $code==1) $ccode = 'green';
	else  $ccode = 'red';
?>

<div id="message-<?php echo $ccode;?>" style="padding-top:10px;">
  <table border="0" width="100%" cellpadding="0" cellspacing="0">
    <tr>
      <td class="<?php echo $ccode;?>-left"><?php echo $message;?></td>
      <td class="<?php echo $ccode;?>-right"><a class="close-<?php echo $ccode;?>"><img src="images/table/icon_close_<?php echo $ccode;?>.gif"   alt="" /></a></td>
    </tr>
  </table>
</div>
<?php
}
?>

<form action="" method="post" name="frmForgetPassword">
<table border="0" cellpadding="0" cellspacing="0" id="id-form">
  <tr>
    <th valign="top">Username : </th>
    <td><?php echo $rasUser['username'];?></td>
  </tr>
  <tr>
    <th valign="top">Old Password :</th>
    <td><input id="old_password" type="password" name="old_password" value="" class="inp-form"  /></td>
  </tr>
  <tr>
    <th valign="top">New Password :</th>
    <td><input id="new_password" type="password" name="new_password" value="" class="inp-form"  /></td>
  </tr>
  <tr>
    <th valign="top">Confirm Password :</th>
    <td><input id="conf_password" type="password" name="conf_password" value="" class="inp-form" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td valign="top" colspan="2"> <input id="btnChange" name="btnChange" type="submit" value="Save" class="button" /></td>
  </tr>
</table>
</form>