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
    <table border="0" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="7" style="border:0px !important;"></td>
        </tr>
        <?php
        //$result = $menuObj->getCategoriesByParentid($parent_id);
        $result = $mydb->getQuery('*', 'tbl_category', 'parent_id=' . $parent_id);
        if (mysql_num_rows($result) != 0) {
            ?>
            <tr class="no-hover">
                <th class="table-header-check">S.N</th>
                <th class="table-header-repeat line-left minwidth-1">Name</th>
                <?php if (isset($_GET['p']) && $_GET['p'] == 0) { ?>
                    <th class="table-header-repeat line-left">No of Subcategories</th>
                <?php } ?>
                <th class="table-header-repeat line-left">Type of Products</th>
                <th class="table-header-repeat line-left align-right">Total Cost Price</th>
                <th class="table-header-repeat line-left align-right">Total MRP</th>
                <th class="table-header-options line-left">Options</th>
            </tr>
            <?php
            $counter = 0;
            $gtotal_costprice = 0;
            $gtotal_mrp = 0;
            while ($rasmenu = $mydb->fetch_array($result)) {
                $cid = $rasmenu['id'];
                $p = $_GET['p'];
                if (isset($_GET['p']) && $_GET['p'] == 0)
                    $cond = 'cid=' . $cid;
                else
                    $cond = 'scid=' . $cid;

                $no_of_products = $mydb->getCount('id', 'tbl_product', $cond);
                $total_costprice = $mydb->getSum('costprice', 'tbl_product', $cond);
                $total_mrp = $mydb->getSum('mrp', 'tbl_product', $cond);
                ?>
                <tr>
                    <td><?php echo ++$counter; ?></td>
                    <td><?php echo $generalObj->ahref(ADMINURLPATH . 'category_manage&p=' . $cid, $rasmenu["name"]); ?></td>
                    <?php if (isset($_GET['p']) && $_GET['p'] == 0) { ?>
                        <td><?php echo $mydb->getCount('id', 'tbl_category', 'parent_id=' . $cid); ?></td>
                    <?php } ?>
                    <td><?php echo $no_of_products; ?></td>
                    <td class="price"><?php if ($total_costprice > 0) echo 'Rs. ' . $total_costprice;
                        $gtotal_costprice += $total_costprice; ?></td>
                    <td class="price"><?php if ($total_mrp > 0) echo 'Rs. ' . $total_mrp;
                        $gtotal_mrp += $total_mrp; ?></td>
                    <td class="options-width">
                        <a href="<?php echo ADMINURLPATH . 'category_edit&id=' . $cid; ?>" title="Edit"
                           class="icon-1 info-tooltip"></a>
                        <a href="javascript:void(0);"
                           onclick="callDelete('<?php echo ADMINURLPATH . 'category_manage&p=' . $p . '&did=' . $cid; ?>');"
                           title="Delete" class="icon-2 info-tooltip"></a>
                        <?php if (isset($_GET['p']) && $_GET['p'] == 0) { ?>
                            <a href="<?php echo ADMINURLPATH . 'category_add&p=' . $cid; ?>" title="Add Sub-Category"
                               class="icon-3 info-tooltip"></a>
                        <?php } else { ?>
                            <a href="<?php echo ADMINURLPATH . 'product_manage&p=' . $cid; ?>" title="Add Product"
                               class="icon-5 info-tooltip"></a>
                        <?php } ?>
                    </td>
                </tr>
                <?php
            }
            ?>
            <tr class="no-hover">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <?php if (isset($_GET['p']) && $_GET['p'] == 0) { ?>
                    <td>&nbsp;</td>
                <?php } ?>
                <td>&nbsp;</td>
                <td class="gtotal"><?php if ($gtotal_costprice > 0) echo 'Rs. ' . $gtotal_costprice; ?></td>
                <td class="gtotal"><?php if ($gtotal_mrp > 0) echo 'Rs. ' . $gtotal_mrp; ?></td>
                <td class="options-width">&nbsp;</td>
            </tr>
            <?php
        }
        ?>
    </table>
    <!--  end product-table................................... -->
</form>


<?php
/*
 *  sale item
 */
?>

<!--
<script>

    /*     $("form").on('submit', function(){
     $('.modal').show();
     })
     */
</script>

--><?php
/*
}

*/ ?>



<?php

/*
* show product if searched trhough date and keyword
*/

if (isset($_POST['btnCal'])) {

    ?>
    <script type="text/javascript">
        $('#hideTable').hide();
    </script>
    <script type="text/javascript">
        $('#hideForm').hide();
    </script>

    <form action="" method="post" name="productOrdering" id="showForm ">
        <table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table" class="product-table">
            <tr class="no-hover">
                <th class="table-header-check">S.N</th>
                <th class="table-header-repeat line-left minwidth-1">Name</th>
                <th class="table-header-repeat line-left minwidth-1">Date Added</th>
                <th class="table-header-repeat line-left">Information</th>
                <th class="table-header-repeat line-left qty ">Qty</th>
                <th class="table-header-repeat line-left minwidth-1 align-right">Cost/Unit</th>
                <th class="table-header-repeat line-left align-right mrp">MRP</th>
                <th class="table-header-repeat line-left minwidth-1 align-right">SOLD QTY</th>
                <th class="table-header-options line-left">Options</th>
            </tr>

            <?php

            $counter = 0;/*
            if(!isset($_POST['from']) || isset($_POST['to'])){

            }
if(isset($_POST['from'])){
    $from = "'".$_POST['from']."'";
    $query[] = "from =".$from;
}
            if(isset($_POST['to'])){
                $to = "'".$_POST['to']."'";
                $query[] = "to =".$to;
}
            if(isset($_POST['search'])){
                $key = "'%".$_POST['search']."%'";
                $query[] = "keyword =".$key;
}
            $where = implode(' and ', $query);
echo $where;*/
            $from = $_POST['from'];
            //var_dump($from);
            $to = $_POST['to'];
            $search = $_POST['search'];
            if ($from != "" && $to != "" && $search != "") {
//print_r("select * from tbl_product where (date_added BETWEEN  '$from' and '$to') or name like '%$search%' or description like '%$search%' or quantity like %$search% or costprice like %$search% or mrp like %$search% ORDER by date_added DESC");
                $calSearch = mysql_query("select * from tbl_product where (date_added BETWEEN  '$from' and '$to') and( name like '%$search%' or description like '%$search%' or quantity like '%$search%' or costprice like '%$search%' or mrp like '%$search%') ORDER by date_added DESC") or die(mysql_query());
            }
            if ($from != "" && $to != "" && $search == "") {
                // echo "2";
                $calSearch = mysql_query("select * from tbl_product where (date_added BETWEEN  '$from' and '$to') ORDER by date_added DESC") or die(mysql_query());
            }
            if ($from == "" && $to == "" && $search != "") {
                //print_r("select * from tbl_product where name like ''%$search%''  ORDER by date_added DESC");
                //print_r("select * from tbl_product where name like '%$search%' or description like '%$search%' or quantity like %$search% or costprice like %$search% or mrp like %$search% ORDER by date_added DESC");
                $calSearch = mysql_query("select * from tbl_product where name like '%$search%' or description like '%$search%' or quantity like '%$search%' or costprice like '%$search%' or mrp like '%$search%' ORDER by date_added DESC") or die(mysql_query());
            }

            //             $calse = $mydb->getQuery('name, date_added', 'tbl_product', '(date_added between "' . $from . '" and "' . $to . '")  order by date_added desc','1');

            $count = mysql_num_rows($calSearch);

            if ($from > $to) {
                ?>

                <div class="alert alert-danger" id="hideThiss">

                    From date is greater than to date.Please enter valid date range..


                </div>
                <?php
            }
            if ($from == "" && $to != "") {
                ?>

                <div class="alert alert-danger" id="hideThiss">
                    Please enter from field.Please enter valid date range.
                </div>
                <?php
            }
            if ($from != "" && $to == "") {
                ?>
                <div class="alert alert-danger" id="hideThiss">
                    Please enter to field.Please enter valid date range.
                </div>
                <?php
            }
            if ($from == "" && $to == "" && $search == "") {
                ?>
                <div class="alert alert-danger" id="hideThiss">
                    Please enter field.
                </div>
                <?php
            }
            if ($count == 0) {
                ?>
                <div class="alert alert-danger" id="hideThiss">
                    no data
                </div>
                <?php
            } else {

                ?>
                <?php
                // while ($row = $mydb->fetch_array($calse)) {
                while ($row = mysql_fetch_array($calSearch)) {
                    ?>
                    <tr>
                        <td style="text-align:center"><?php echo ++$counter; ?></td>
                        <td><?php echo stripslashes($row['name']); ?></td>
                        <td><?php echo stripslashes($row['date_added']); ?>
                        </td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td class="price">Rs. <?php echo $row['costprice']; ?></td>
                        <td class="price">Rs. <?php echo $row['mrp']; ?></td>
                        <td class="price"><?php echo $row['sold_quantity']; ?></td>
                        <td class="options-width">
                            <a href="<?php echo ADMINURLPATH . 'product_manage&id=' . $row["id"]; ?>"
                               title="Edit" class="btn-com info-tooltip">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="javascript:void(0);" title="Delete" class="info-tooltip btn-com"
                               onclick="callDeleteProduct('<?php echo $cid; ?>','<?php echo $pid; ?>');">
                                <i class="fa fa-trash"></i>
                            </a>
                            <a href="#" onclick="popupSales(<?php echo $row['id']; ?>)"
                               title="Sale" class="btn-com info-tooltip">
                                <i class="fa fa-shopping-cart"></i>
                            </a>
                        </td>
                    </tr>

                    <?php
                }
            }

            ?>
        </table>
    </form>
    <?php
}
?>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4>Sales</h4>

            </div>
            <div class="modal-body">

                <form method="post"
                      action="<?php echo ADMINURLPATH . "sale"; ?>"
                      enctype="multipart/form-data">
                    <center>
                        <div id="showResult"></div>

                        <input id="ppMRP" class="" type="hidden"><br>
                        <input id="ppcostprice" class="" type="hidden"><br>
                        Total Price: <span id="ss" class=""></span>
                        <br>
                        Cost Price:   <span id="cs" class="">

                        </span>
                    </center>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="text" class="form-control " id="qty" name="quantity"
                               placeholder="Quantity" width="50px">
                    </div>

                    <div class="form-group">
                        <label for="saleprice">Amount per item</label>
                        <input type="text" class="form-control " id="amount_per_item"
                               placeholder="amount per item">
                    </div>
                    <div class="form-group">
                        <label for="saleprice">Amount Paid</label>
                        <input type="text" class="form-control " id="total_sale_prices" name="saleprice"
                               placeholder="saleprice">
                    </div>
                    <div class="form-group">

                        <input type="hidden" class="form-control " id="costprice" name="costprice"
                               placeholder="costprice">
                    </div>
                    <div class="form-group">
                        <label for="remarks">Remark</label>
                        <input type="text" class="form-control " id="remarks" name="remarks"
                               placeholder="remarks">
                    </div>
                    <div class="form-group">

                        <input type="hidden" class="form-control" id="salesID" name="pid"
                               placeholder="" value="product id">

                    </div>
                    <select name="saletype" id="saletype" class="styledselectbox" style="display: none;">
                        <option value="Product"
                                style="height:32px;" <?php if (isset($_POST['saletype']) && $_POST['saletype'] == 'Product') echo 'selected'; ?>>
                            Product
                        </option>

                    </select>
                    <div class="form-group">

                        <input type="ca" class="form-control inp-form" id="sale_date" name="sale_date"
                               value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <input name="btnDo" id="btnDo" type="submit" value="Submit"
                           class="button"/>


            </div>

            </form>


        </div>
        <!-- <div class="modal-footer">
             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
             <button type="button" class="btn btn-primary">sale</button>
         </div>-->
    </div>
</div>
<div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4>Add Category</h4>

            </div>
            <div class="modal-body">


                <form name="form1" method="post" action="" enctype="multipart/form-data" id="mainform">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" id="id-form">

                        <tr>
                            <th width="15%">Name:</th>
                            <td><input type="text" name="name" id="name"
                                       value="" class="inp-form"/></td>
                        </tr>
                        <tr>
                            <th valign="top">Description:</th>
                            <td><textarea name="description" id="description" cols="" rows=""
                                          class="form-textarea"></textarea></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td><input name="btnadd" type="submit" value="Add" class="button"
                                       onMouseOut="this.className='button'"
                                       onMouseOver="this.className='button'"/></td>
                        </tr>
                    </table>
                </form>

            </div>
            <!-- <div class="modal-footer">
                 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                 <button type="button" class="btn btn-primary">sale</button>
             </div>-->
        </div>
    </div>

</div>

<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4>Add Product</h4>

            </div>
            <div class="modal-body">


                <form name="productInsert" method="post" action="" enctype="multipart/form-data" id="mainform">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" id="id-form">

                        <tr>
                            <th>Date :</th>
                            <td>
                                <input name="date_added" type="text" id="date_added"
                                       placeholder="added date"
                                       value="<?php echo date('Y-m-d'); ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <th>Category :</th>
                            <td>
                                <?php
                                if (isset($_GET['p']))
                                //$cid = $_GET['p'];
                                ?>
                                <select name="cid" id="cid" onchange=""
                                        class="styledselectbox">
                                    <option>Select Category</option>
                                    <?php
                                    $resCat = $mydb->getQuery('id,name', 'tbl_category');
                                    while ($rasCat = $mydb->fetch_array($resCat)) {
                                        ?>
                                        <option id="cidoption"
                                                value="<?php echo $rasCat['id']; ?>" <?php if ($cid == $rasCat['id']) echo 'selected'; ?>><?php echo $rasCat['name']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <th>Name :</th>
                            <td><input name="name" id="name" type="text"
                                       class="inp-form"/>
                            </td>
                        </tr>
                        <tr>
                            <th>Description :</th>
                            <td><textarea name="description" id="description" cols="120" rows="7"
                                          class="form-textarea"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th>Quantity :</th>
                            <td><input name="quantity" id="quantity" type="text"

                                       class="inp-form"/></td>
                        </tr>
                        <tr>
                            <th>Cost Price</th>
                            <td><input name="costprice" id="costprice" type="text"

                                       class="inp-form"/></td>
                        </tr>
                        <tr>
                            <th>MRP :</th>
                            <td><input name="mrp" id="mrp" type="text"
                                       class="inp-form"/></td>
                        </tr>
                        <tr>
                            <td align="right">&nbsp;</td>
                            <td style="padding-bottom:15px;"><input name="submit" type="submit"
                                                                    value="<?php echo 'Add'; ?>" onclick="saveProduct()"
                                                                    class="button"/></td>
                        </tr>
                    </table>
                </form>


            </div>
            <!-- <div class="modal-footer">
                 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                 <button type="button" class="btn btn-primary">sale</button>
             </div>-->
        </div>
    </div>

</div>
