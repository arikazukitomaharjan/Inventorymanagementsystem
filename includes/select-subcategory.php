<?php
require_once("../classes/call.php");
$cid = $_POST['cid'];
?>
<select name="scid" id="scid"  class="styledselectbox">
    <option value="">Select sub Category</option>
    <?php
	if($cid>0)
	{
    $resCat = $mydb->getQuery('id,name','tbl_category','parent_id='.$cid);
    while($rasCat = $mydb->fetch_array($resCat))
    {
    ?>
    <option value="<?php echo $rasCat['id'];?>"><?php echo $rasCat['name'];?></option>
    <?php
	}
    }
    ?>
</select>