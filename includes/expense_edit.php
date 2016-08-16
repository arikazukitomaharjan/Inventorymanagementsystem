<?php
/**
 * Created by PhpStorm.
 * User: sabin
 * Date: 6/15/16
 * Time: 12:13 PM
 */

include("../classes/category.class.php");
$id = $_GET['id'];
$edit = $mydb->getQuery('name,description,date,cost', 'tbl_expense', 'id=' . $id);
$row = $mydb->fetch_array($edit);

if (isset($_POST['btnupdate'])){
    $data="";
    $data['name']=$_POST['name'];
    $data['description']=$_POST['description'];
    $data['cost']=$_POST['cost'];
    $data['date']=$_POST['date'];
    $mess=$mydb->updateQuery('tbl_expense', $data, 'id='.$id);
    $url=   ADMINURLPATH."expense&code=1&message=".$mess;
    $mydb->redirect($url);
   /* $url = ADMINURLPATH."category_add&code=1&message=".$mess;
    $mydb->redirect($url);*/


}

?>

<form name="form1" method="post" action="" enctype="multipart/form-data" id="mainform">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" id="id-form">
        <tr>
            <th>Name:</th>
            <td><input type="text" name="name" id="name" value="<?php echo $row['name']; ?>" class="inp-form"/></td>
        </tr>
        <tr class="TitleBarA">
            <th>Description:</th>
            <td><textarea name="description" id="description" cols="" rows=""
                          class="form-textarea"><?php echo $row['description']; ?></textarea></td>
        </tr>
        <tr>
            <th>Cost:</th>
            <td><input type="number" name="cost" id="cost" value="<?php echo $row['cost']; ?>" class="inp-form"/></td>
        </tr>
        <tr>
            <th>Date:</th>
            <td><input type="date" name="date" id="date" value="<?php echo $row['date']; ?>" class="inp-form tcal"/>
            </td>
        </tr>


        <tr>
            <td>&nbsp;</td>
            <td><input name="btnupdate" type="submit" value="Update" class="button" onMouseOut="this.className='button'"
                       onMouseOver="this.className='button'"/></td>
        </tr>

    </table>
</form>