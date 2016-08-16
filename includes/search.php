<script type="text/javascript">
 function callDeleteProduct(p,dprid)
 {
	if(confirm('Are you sure to delete ?'))
	{
	window.location='?manager=category_manage&p='+p+'&dpid='+dprid;
	}
 }
</script>
<?php
if(isset($_POST['btnsvOrder']))
{
	$count = count($_POST['pid']);
	for($i=0;$i<$count;$i++)
	{
		$productObj->updateOrdering($_POST['pid'][$i],$_POST['ordering'][$i]);
	}
}

if(isset($_GET['dpid']))
{
	$delId = $_GET['dpid'];	
	$mess = $mydb->deleteQuery('tbl_product','id='.$delId);
	$url = ADMINURLPATH."search&p=".$p."&code=1&keyword=".$mess;
	$mydb->redirect($url);
}

$keyword = $_GET['keyword'];
//echo $mydb->getQuery('*','tbl_product','name LIKE "%'.$keyword.'%" OR itemcode LIKE "%'.$keyword.'%" ORDER BY date_added DESC','1');
$result = $mydb->getQuery('*','tbl_product','name LIKE "%'.$keyword.'%" OR itemcode LIKE "%'.$keyword.'%" GROUP BY id ORDER BY date_added DESC');
$count = mysql_num_rows($result);
if($count != 0)
{
?>
	<form action="" method="post" name="productOrdering" id="mainform">
	  <table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table" class="product-table">
		<tr class="no-hover">
		  <th class="table-header-check">S.N </th>
          <th class="table-header-repeat line-left minwidth-1">Name</th>
          <th class="table-header-repeat line-left minwidth-1">Date Added</th>
          <th class="table-header-repeat line-left minwidth-1">Itemcode</th>
          <th class="table-header-repeat line-left">Quantity</th>
          <th class="table-header-repeat line-left align-right">Cost Price</th>
          <th class="table-header-repeat line-left align-right">MRP</th>
          <th class="table-header-options line-left">Options</th>
		</tr>
		<?php
		$counter = 0;
		while($rasProduct = $mydb->fetch_array($result))
		{
		$pid = $rasProduct['id'];
		$cid = $rasProduct['scid'];
		?>
		<tr>
		  <td style="text-align:center"><?php echo ++$counter;?></td>
		  <td><?php echo stripslashes($rasProduct['name']);?></td>
		  <td><?php echo stripslashes($rasProduct['date_added']);?></td>
		  <td><?php echo stripslashes($rasProduct['itemcode']);?></td>
		  <td><?php echo $rasProduct['quantity'];?></td>
		  <td class="price">Rs. <?php echo $rasProduct['costprice'];?></td>
		  <td class="price">Rs. <?php echo $rasProduct['mrp'];?></td>
		  <td class="options-width">
            <a href="<?php echo ADMINURLPATH.'product_manage&p='.$cid.'&id='.$rasProduct["id"];?>" title="Edit" class="icon-1 info-tooltip"></a>            
		  </td>
		</tr>
		<?php
		}
		?>
	  </table>
	</form>
<?php
}
?>