<?php
/**
 * Created by PhpStorm.
 * User: sabin
 * Date: 6/9/16
 * Time: 11:29 AM
 */

include("../classes/call.php");
if (isset($_POST['btnRegister'])) {
    $getpass = $mydb->CleanString($_POST['password']);
    $getusername = $mydb->CleanString($_POST['username']);
//print_r($_POST);
    $dbpass = $mydb->md5_encrypt("msnH0b@@1", SECRETPASSWORD);
    echo $dbpass;
    die();
    die();
    $register = mysql_query("insert into tbl_admin(username,pass) values('$getusername','$password')");
}

/*$password = "banana";
$salt = "a12dsfg33B1cD2eF3G"; # Can be any assortment of characters
$password = md5($salt.$password);*/
?>

<form action="" method="post" name="frmRegister">
    <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <th>Username</th>
            <td><input name="username" id="username" type="text" class="login-inp"/></td>
        </tr>
        <tr>
            <th>Password</th>
            <td><input name="password" id="password" type="password" onfocus="this.value=''" class="login-inp"/></td>
        </tr>

        <tr>
            <th></th>
            <td><input name="btnRegister" type="submit" class="submit-login" value="register"/></td>
        </tr>
        <tr>
            <td colspan="2">You just need to click on submit to login</td>
        </tr>
    </table>
</form>
