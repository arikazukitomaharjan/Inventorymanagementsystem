<?php
/*
 *  sale item
 */

//print_r($_POST);
//print_r($_SESSION);
$message = '';
if (isset($_POST['btnDo'])) {
    if (isset($_POST['saletype']) && $_POST['saletype'] == 'Product') {
        if ($_POST['quantity'] <= 0) {
            $message .= 'Invalid Quantity';
        }
        if ($_POST['saleprice'] <= 0) {
            $message .= '<br>Amount Paid is mandatory';
        }

        if (empty($message)) {
            $id = $_POST['id'];

            $rasPro = $mydb->getArray('id,quantity', 'tbl_product', 'id="' . $id . '"');
            $av_qty = $rasPro['quantity'];
            $sale_quantity = $_POST['quantity'];

            //echo $av_qty.'->'.$sale_quantity;
            echo "quantity=" . $av_qty;

            if ($av_qty >= $sale_quantity) {
                $data = '';
                $data['quantity'] = $av_qty - $sale_quantity;
                $mydb->updateQuery('tbl_product', $data, 'id="' . $id . '"');
            } else {

                $message = 'Sale quantity cannot be greater than available quantity.';
            }

            if (empty($message)) {
                $data = '';
                foreach ($_POST as $key => $value) {
                    if ($key != 'btnDo' && $key != 'id')
                        $data[$key] = $value;
                }
                $data['sale_datetime'] = date('Y-m-d H:i:s');
                $data['sold_by'] = $_SESSION[ADMINUSER];
                $mydb->insertQuery('tbl_sale', $data);

                $url = ADMINURLPATH . "sale&code=1&message=The selected product has been sold successfully.";
                $mydb->redirect($url);
            }
        }
    } else {
        if ($_POST['saleprice'] <= 0) {
            $message .= '<br>Amount Paid is mandatory';
        }

        if (empty($_POST['remarks'])) {
            $message .= 'Remarks is mandatory.';
        }

        if (empty($message)) {
            $data = '';
            $data['sale_date'] = $_POST['sale_date'];
            $data['sale_datetime'] = date('Y-m-d H:i:s');
            $data['saletype'] = $_POST['saletype'];
            $data['saleprice'] = $_POST['saleprice'];
            $data['remarks'] = $_POST['remarks'];
            $data['sold_by'] = $_SESSION[ADMINUSER];
            $mydb->insertQuery('tbl_sale', $data);

            $url = ADMINURLPATH . "sale&code=1&message=Service has been charged successfully.";
            $mydb->redirect($url);
        }
    }
}

/*
 * update product
 */
if (isset($_POST['btnUpdateProduct'])) {
    $data = "";
    $id = $_POST['idProduct'];

    $data['name'] = $_POST['name'];
    $data['description'] = $_POST['description'];
    $data['date_added'] = $_POST['date_added'];
    $data['quantity'] = $_POST['quantity'];
    $data['costprice'] = $_POST['costprice'];
    $data['mrp'] = $_POST['mrp'];
    $data['cid'] = $_POST['cid'];

    $mess = $mydb->updateQuery('tbl_product', $data, 'id=' . $id);
    $p = $_GET['p'];

    $url = ADMINURLPATH . "category_manage&p=" . "0" . "&code=1&message=" . $mess;
    $mydb->redirect($url);
    ?>
    <script type="application/javascript">

        setTimeout(function () {
            $("#message-green").fadeOut(1500);
        }, 5000)
    </script>

    <?php
    
//        echo "<script>alert(".$mess.");</script>;
}
/*
 * add product
 */
$cid = $_GET['p'];
if ((isset($_POST['btnCal']) && $cid == 0)) {

    ?>
    <script type="text/javascript">
        $('#hideTable').hide();
    </script>
    <script type="text/javascript">
        $('#hideForm').hide();
    </script>


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
            $id = $row['id'];
            $pid = $row['id'];
            $name = $row['name'];
            $date_added = $row['date_added'];
            $description = $row['description'];
            $quantity = $row['quantity'];
            $costprice = $row['costprice'];
            $mrp = $row['mrp'];
            $cid = $row['cid'];
            $sold_quantity = $row['sold_quantity'];
            $total_quantity = $sold_quantity + $quantity;
            $query = "select monthname(date_added) as month, day(date_added) as day, year(date_added) as year from tbl_product where id=" . $pid;
            $date = mysql_query($query);

            $resultQuery = mysql_fetch_array($date);
            ?>

            <tr>
                <td style="text-align:center"><?php echo ++$counter; ?></td>

                <td><?php echo stripslashes($row['name']); ?></td>
                <td><?php echo stripslashes($resultQuery['day']); ?>
                    &nbsp;<?php echo stripslashes($resultQuery['month']); ?>
                    ,&nbsp; <?php echo stripslashes($resultQuery['year']); ?></td>
                </td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $total_quantity ?></td>
                <td><?php echo $row['quantity']; ?></td>
                <td class="price">Rs. <?php echo $row['costprice']; ?></td>
                <!--                        <td class="price">Rs. --><?php //echo $row['mrp']; ?><!--</td>-->
                <td class="price"><?php echo $row['sold_quantity']; ?></td>
                <td class="options-width">
                    <button href="<?php /*echo ADMINURLPATH . 'product_manage&id=' . $rasProduct["id"]; */ ?>"
                            title="Edit" class="btn-com info-tooltip" type="button"
                            onclick="editProduct('<?php echo $id; ?>','<?php echo $name; ?>','<?php echo $date_added; ?>','<?php echo $description; ?>','<?php echo $quantity; ?>','<?php echo $costprice; ?>','<?php echo $mrp; ?>' ,'<?php echo $cid; ?>')">
                        <i class="fa fa-edit"></i>
                    </button>
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


    <?php
}
?>
</table>

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
                        <!--                        Total Price: <span id="ss" class=""></span>-->
                        Cost Price:   <span id="cs" class="">
                        <br>


                        </span>
                    </center>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="text" class="form-control " id="qty" name="quantity"
                               placeholder="Quantity" width="50px">
                    </div>
                    <div class="form-group">
                        <label for="saleprice">Amount Paid</label>
                        <input type="text" class="form-control " id="total_sale_prices" name="saleprice"
                               placeholder="saleprice">
                    </div>
                    <div class="form-group">
                        <label for="saleprice">Amount per item</label>
                        <input type="text" class="form-control " id="amount_per_item"
                               placeholder="amount per item">
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

                <div id="showCategoryAlert">
                    <div class="alert alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <span id="showMsg">Category was successfully added</span>
                    </div>
                </div>
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
                        <td><input name="addcategory" type="submit" value="Add" class="button"
                                   onclick="saveCategory()"/></td>
                    </tr>
                </table>


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
                <div id="showAlert">
                    <div class="alert alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <span id="showMsg">Product was successfully added</span>
                    </div>
                </div>

                <!-- <span id="imgSpin">
                     <img src="../img/loader.gif"/>
                 </span>-->
                <table width="100%" cellpadding="0" cellspacing="0" border="0" id="id-form">

                    <tr>
                        <th>Date :</th>
                        <td>
                            <input name="date_added" type="text" id="date_added" placeholder="added date"
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
                            <select name="cid" id="cids" onchange=""
                                    class="styledselectbox">
                                <option value="0">Select Category</option>
                                <?php
                                $resCat = $mydb->getQuery('id,name', 'tbl_category');
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
                        <th>Name :</th>
                        <td><input name="name" id="names" type="text" value="<?php echo $rasProduct['name']; ?>"
                                   class="inp-form"/>
                        </td>
                    </tr>
                    <tr>
                        <th>Description :</th>
                        <td><textarea name="description" id="descriptions" cols="120" rows="7"
                                      class="form-textarea"><?php echo $rasProduct['description']; ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>Quantity :</th>
                        <td><input name="quantity" id="quantity" type="text"
                                   value="<?php echo $rasProduct['quantity']; ?>"
                                   class="inp-form"/></td>
                    </tr>
                    <tr>
                        <th>Cost Price</th>
                        <td><input name="costprice" id="costprices" type="text"
                                   value="<?php echo $rasProduct['costprice']; ?>"
                                   class="inp-form"/></td>
                    </tr>
                    <tr>

                        <td><input name="mrp" id="mrp" type="hidden"
                                   value="0"
                                   class="inp-form"/></td>
                    </tr>

                    <tr>
                        <td align="right">&nbsp;</td>
                        <td style="padding-bottom:15px;"><input name="saves" type="submit"
                                                                value="<?php echo 'Add'; ?>"
                                                                class="button" onclick="saveProduct()"/>
                            <input name="bulkAdd" type="submit"
                                   value="<?php echo 'Bulk Add'; ?>"
                                   class="button" onclick="window.location='?manager=bulk_add_product'"/></td>
                    </tr>
                </table>


            </div>
            <!-- <div class="modal-footer">
                 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                 <button type="button" class="btn btn-primary">sale</button>
             </div>-->
        </div>
    </div>

</div>
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4>Edit Product</h4>

            </div>
            <div class="modal-body">
                <form name="form1" method="post" action="" enctype="multipart/form-data" id="mainform">

                    <table width="100%" cellpadding="0" cellspacing="0" border="0" id="id-form">

                        <input name="idProduct" type="text" id="idproductssss" style="visibility: hidden;"/>

                        <tr>
                            <th>Date :</th>
                            <td>
                                <input name="date_added" type="text" id="date_addedproduct" placeholder="added date"
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
                                <select name="cid" id="cidproduct" onchange=""
                                        class="styledselectbox">
                                    <option value="0">Select Category</option>
                                    <?php
                                    $resCat = $mydb->getQuery('id,name', 'tbl_category');
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
                            <th>Name :</th>
                            <td><input name="name" id="nameproduct" type="text"
                                       class="inp-form"/>
                            </td>
                        </tr>
                        <tr>
                            <th>Description :</th>
                            <td><textarea name="description" id="descriptionproduct" cols="120" rows="7"
                                          class="form-textarea"><?php echo $rasProduct['description']; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th>Quantity :</th>
                            <td><input name="quantity" id="quantityproduct" type="text"
                                       value="<?php echo $rasProduct['quantity']; ?>"
                                       class="inp-form"/></td>
                        </tr>
                        <tr>
                            <th>Cost Price</th>
                            <td><input name="costprice" id="costpriceproduct" type="text"
                                       value="<?php echo $rasProduct['costprice']; ?>"
                                       class="inp-form"/></td>
                        </tr>
                        <tr>
                            <th>MRP :</th>
                            <td><input name="mrp" id="mrpproduct" type="text" value="<?php echo $rasProduct['mrp']; ?>"
                                       class="inp-form"/></td>
                        </tr>
                        <tr>
                            <td align="right">&nbsp;</td>
                            <td style="padding-bottom:15px;"><input name="btnUpdateProduct" type="submit"
                                                                    value="<?php echo 'Update'; ?>"
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