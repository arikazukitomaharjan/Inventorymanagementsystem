<script type="text/javascript">
    // JavaScript Document
    function listSubcategory(cid) {
        $('#subcategory').load("includes/select-subcategory.php", {'cid': cid});
        $('#subcategory').change(function(){

            var id = $('#subcategory option:selected').val(id);

            window.location.href= "http://localhost/ims/index.php?manager=category_manage&p="+id;

        });
    }

    function callDelete(url) {
        var bool;
        bool = confirm('Are you sure to delete ? The process is irreversible.');
        if (bool)
            window.location = url;
    }
</script>
<?php
if (isset($_POST['btnOrder'])) {
    $count = count($_POST['cid']);
    for ($i = 0; $i < $count; $i++) {
        $cid = $_POST['cid'][$i];
        $data = "";
        $data['ordering'] = $_POST['ordering'][$i];
        $mydb->updateQuery('tbl_category', $data, 'id=' . $cid);
    }
}

if (isset($_GET['did'])) {
    $p = $_GET['p'];
    $delId = $_GET['did'];
    if ($p == 0) {
        $resCat = $mydb->getQuery('id', 'tbl_category', 'parent_id=' . $delId);
        while ($rasCat = $mydb->fetch_array($resCat)) {
            $catid = $rasCat['id'];
            $mydb->deleteQuery('tbl_category', 'id=' . $catid);
        }//Delete All sub-categories under the main category

        $mydb->deleteQuery('tbl_product', 'cid=' . $delId); //Delete All products under the main category

        $mess = "The selected category including all subcategories and products under this category has been deleted successfully.";
    } else {
        $mydb->deleteQuery('tbl_product', 'scid=' . $delId); //Delete All products under the sub category
        $mess = "The selected subcategory and all products under this subcategory has been deleted successfully.";
    }

    $mydb->deleteQuery('tbl_category', 'id=' . $delId); //Delete the category

    $url = ADMINURLPATH . "category_manage&p=" . $p . "&code=1&message=" . $mess;
    $mydb->redirect($url);
}

if (isset($_GET['p'])) {
    $cat_id = $_GET['p'];
    $parID = $mydb->getvalue('parent_id', 'tbl_category', 'id=' . $cat_id);
} else {
    $parID = 0;
}

?>
<?php
if (isset($_GET['message'])) {
    if (isset($_GET['code']) && $_GET['code'] == 1) $ccode = 'green';
    else  $ccode = 'red';
    ?>


    <div id="message-<?php echo $ccode; ?>" style="padding-top:10px;">
        <table border="0" width="100%" cellpadding="0" cellspacing="0">
            <tr>

                <td class="<?php echo $ccode; ?>-left"><?php echo $_GET['message']; ?></td>
                <td class="<?php echo $ccode; ?>-right"><a class="close-<?php echo $ccode; ?>"><img
                            src="images/table/icon_close_<?php echo $ccode; ?>.gif" alt=""/></a></td>
            </tr>
            <tr>
                <th>Category :</th>
                <td>
                    <?php
                    if (isset($_GET['p']))
                    //$cid = $_GET['p'];
                    ?>
                    <select name="cid" id="cid" onchange="listSubcategory(this.value);" class="styledselectbox">
                        <option value="0">Select Category</option>
                        <?php
                        $resCat = $mydb->getQuery('id,name', 'tbl_category', 'parent_id=0');
                        while ($rasCat = $mydb->fetch_array($resCat)) {
                            ?>
                            <option
                                value="<?php echo $rasCat['id']; ?>" <?php if ($cid == $rasCat['id']) echo 'selected'; ?>><?php echo $rasCat['name']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Sub Category :</th>
                <td id="subcategory">
                    <select name="scid" id="scid" class="styledselectbox">
                        <option value="">Select sub Category</option>
                        <?php
                        if ($cid > 0) {
                            $resCat = $mydb->getQuery('id,name', 'tbl_category', 'parent_id=' . $cid);
                            while ($rasCat = $mydb->fetch_array($resCat)) {
                                ?>
                                <option
                                    value="<?php echo $rasCat['id']; ?>" <?php if ($scid == $rasCat['id']) echo 'selected'; ?>><?php echo $rasCat['name']; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
        </table>
    </div>
    <?php
}
?>
<form id="mainform" action="">
    <table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
        <tr>
            <td colspan="2"><a href="<?php echo ADMINURLPATH . 'category_manage&p=0'; ?>">Root</a>
                <?php
                $count = count($catarr);
                for ($i = ($count - 1); $i >= 0; $i--) {
                    echo $generalObj->ahref(ADMINURLPATH . 'category_manage&p=' . $catarr[$i], $mydb->getValue('name', 'tbl_category', 'id=' . $catarr[$i])) . " > ";
                }

                $arrcount = count($catarr);

                if ($arrcount == 1)
                    $catname = 'Root';
                elseif ($arrcount == 2)
                    $catname = $mydb->getValue('name', 'tbl_category', 'id=' . $catarr[$count - 2]);
                elseif ($arrcount == 3)
                    $catname = $mydb->getValue('name', 'tbl_category', 'id=' . $catarr[$count - 3]);


                if (isset($_GET['p']) && $_GET['p'] > 0) $btnValue = 'Add subcategory';
                else $btnValue = 'Add category';
                ?>
            </td>
            <td>

                <?php
                if (isset($_GET['p']))
                //$cid = $_GET['p'];
                ?>
                <select name="cid" id="cid" onchange="listSubcategory(this.value);" class="styledselectbox">
                    <option value="0">Select Category</option>
                    <?php
                    $resCat = $mydb->getQuery('id,name', 'tbl_category', 'parent_id=0');
                    while ($rasCat = $mydb->fetch_array($resCat)) {
                        ?>
                        <option
                            value="<?php echo $rasCat['id']; ?>" <?php if ($cid == $rasCat['id']) echo 'selected'; ?>><?php echo $rasCat['name']; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </td>


            <td id="subcategory">
                <select name="scid" id="scid" class="styledselectbox">
                    <option value="">Select sub Category</option>
                    <?php
                    if ($cid > 0) {
                        $resCat = $mydb->getQuery('id,name', 'tbl_category', 'parent_id=' . $cid);
                        while ($rasCat = $mydb->fetch_array($resCat)) {
                            ?>
                            <option
                                value="<?php echo $rasCat['id']; ?>" <?php if ($scid == $rasCat['id']) echo 'selected'; ?>><?php echo $rasCat['name']; ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </td>

            </td>
            <td colspan="4" align="right" style="padding-right:10px;"><?php if ($parID == 0) { ?>
                    <input name="btnAdd" type="button" value="<?php echo $btnValue; ?>" class="button"
                           onMouseOut="this.className='button'" onMouseOver="this.className='button'"
                           onclick="window.location='?manager=category_add&p=<?php echo $parent_id; ?>'"
                           title="<?php echo $btnValue . ' in ' . $catname; ?>"/>
                <?php } else { ?>
                    <input name="btnAddPro" type="button" value="Add Product" class="button"
                           onclick="window.location='?manager=product_manage&p=<?php echo $parent_id; ?>'"
                           title="Add Product in <?php echo $catname; ?>"/>
                <?php } ?></td>
        </tr>
    </table>

    <!--  end product-table................................... -->
</form>
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
    $p = $_GET['p'];
    $delId = $_GET['dpid'];
    $mess = $mydb->deleteQuery('tbl_product','id='.$delId);
    $url = ADMINURLPATH."category_manage&p=".$p."&code=1&message=".$mess;
    $mydb->redirect($url);
}

$cid = $_GET['p'];

//$result = $productObj->getproductBycId($cid);
//echo $cid.'-->'.$scid;
$result = $mydb->getQuery('*','tbl_product','1=1 order by date_added desc');
//echo($result); die();
//$result = mysql_query("Select * from tbl_product order by date_added desc");
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
            $p = $_GET['p'];
            $counter = 0;
            while($rasProduct = $mydb->fetch_array($result))
            {
                $pid = $rasProduct['id'];
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
                        <a href="<?php echo ADMINURLPATH.'product_manage&p='.$p.'&id='.$rasProduct["id"];?>" title="Edit" class="icon-1 info-tooltip"></a>
                        <a href="javascript:void(0);" title="Delete" class="icon-2 info-tooltip" onclick="callDeleteProduct('<?php echo $p;?>','<?php echo $pid;?>');"></a>
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