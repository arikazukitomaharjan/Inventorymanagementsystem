<script type="text/javascript">
    // JavaScript Document
    $('#editAlert').hide();
    function listCategory(cid) {
        window.location.href = "<?php echo SITEROOT;?>index.php?manager=category_manage&p=" + cid;
    }


    function callDelete(url) {
        var bool;
        bool = confirm('Are you sure to delete ? The process is irreversible.');
        if (bool)
            window.location = url;
    }
    $(document).ready(function () {

        $("#hideM").hide();

        /*

         setTimeout(function() {
         $('#hideM').fadeOut('fast');
         }, 1000000000000);
         */


    });
</script>
<script>
    //        $('#hideM').delay(2).fadeOut();
    $(document).ready(function () {
    /*     setTimeout(function() { $("#testdiv").fadeOut(1500); }, 5000)
     //            $('#message-green').delay(2).fadeOut();
     var tm = 0;
     setInterval(function () {
     // Do something every 5 seconds
     if (tm == 1) {

     alert('hello 1 sec');
     $('#message-green').show();
     }

     if (tm == 5) {
     alert('5 sec');
     console.log('5 sec');
     $('#message-green').hide();
     }

     tm = tm + 1;
     }, 1);
     });
     //            $("#message-green").hide();
     });
     */
    /*
     $(document).ready(function () {
     var tm = 0;
     setInterval(function () {
     // Do something every 5 seconds
     if (tm == 1) {


     $('#hideM').show();
     }

     if (tm == 5) {
     alert('5 sec');
     console.log('5 sec');
     $('#hideM').hide();
     }

     tm = tm + 1;
     }, 1);
     });*/
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

    /*    $resCat = $mydb->getQuery('id', 'tbl_category', 'parent_id=' . $delId);
        while ($rasCat = $mydb->fetch_array($resCat)) {
    */
    /*   echo $mydb->deleteQuery('tbl_sale', 'pid=' . $delId,'1');
       $mydb->deleteQuery('tbl_product', 'id=' . $delId); *///Delete All products under the main category

    //$mess = "The selected category including all subcategories and products under this category has been deleted successfully.";

    /* $mydb->deleteQuery('tbl_product', 'scid=' . $delId); //Delete All products under the sub category
     $mess = "The selected subcategory and all products under this subcategory has been deleted successfully.";*/
//    $mydb->deleteQuery('tbl_category', 'id=' . $delId); //Delete the category

//    $mydb->redirect($url);
}

?>

<?php
if (isset($_GET['message'])) { ?>

    <div id="editAlert">
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <span id="showMsg"><?php echo $_GET['message']; ?></span>
        </div>
    </div>
    <script>

            setTimeout(function () {
                $("#editAlert").fadeOut(1500);
            }, 3000);

    </script>
<?php }
?>
<!-- Link to open the modal -->


<form id="mainform" action="" method="post">
    <table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
        <tr>

            <td colspan="2"><a href="<?php echo ADMINURLPATH . 'category_manage&p=0'; ?>">Root ></a>
                <?php
                $count = count($catarr);
                for ($i = ($count - 1); $i >= 0; $i--) {
                    echo $generalObj->ahref(ADMINURLPATH . 'category_manage&p=' . $catarr[$i], $mydb->getValue('name', 'tbl_category', 'id=' . $catarr[$i])) . " > ";
                }

                $arrcount = count($catarr);

                /*   $count = count($catarr);
                   for ($i = ($coudpront - 1); $i >= 0; $i--) {
                       echo $generalObj->ahref(ADMINURLPATH . 'category_manage&p=' . $catarr[$i], $mydb->getValue('name', 'tbl_category', 'id=' . $catarr[$i])) . " > ";
                   }*/

                $btnValue = 'Add category';
                ?>

            <td>
                <?php
                if (isset($_GET['p'])) {
                    $cid = $_GET['p'];

                }

                ?>
                <select name="cid" id="cid" onchange="listCategory(this.value);" class="styledselectbox">
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

            <td>


                <input name="from" type="text" class="datepicker" placeholder="from"
                       value="<?php echo $_POST['from']; ?>"/>
                <input name="to" type="text" class="datepicker" placeholder="to"
                       value="<?php echo $_POST['to']; ?>"/>
                <input name="search" type="text" placeholder="Search" style="width: 120px !important;"
                       value="<?php echo $_POST['search']; ?>"/>
                <input name="btnCal" type="submit" value="Search"/>

            </td>

            <td colspan="4" align="right" style="padding-right:10px;">
                <b>Add: &nbsp;&nbsp;</b>
                <input name="btnAddPro" type="button" value="Product" class="button"
                       onclick="popupProduct()"
                       title="Product"/>
                <!-- <input name="btnAddPro" type="button" value="Add Product" class="button"
                           onclick="window.location='?manager=product_manage&p=0'"
                           title="Add Product"/>-->

                <input class="button" value="Category" type="button" name="category" onclick="addCategory()"
                       title="Category"/>
                <input class="button" value="Expense" type="button" name="expense" onclick="addExpense()"
                       title="Expense"/>
            </td>
        </tr>
    </table>

    <!--  end product-table................................... -->
</form>
<script type="text/javascript">
    function callDeleteProduct(p, dprid) {

        if (confirm('Sales table are too deleted.Are you sure to delete ?')) {
            window.location = '?manager=category_manage&p=' + p + '&dpid=' + dprid;
        }
    }
</script>
<?php
if (isset($_POST['btnsvOrder'])) {
    $count = count($_POST['pid']);
    for ($i = 0; $i < $count; $i++) {
        $productObj->updateOrdering($_POST['pid'][$i], $_POST['ordering'][$i]);
    }
}

if (isset($_GET['dpid'])) {
    $p = $_GET['p'];
    $delId = $_GET['dpid'];

    $mess1 = $mydb->deleteQuery('tbl_sale', 'pid=' . $delId);

    $mess = $mydb->deleteQuery('tbl_product', 'id=' . $delId);
    $url = ADMINURLPATH . "category_manage&p=" . "0" . "&code=1&message=" . $mess;
    $mydb->redirect($url);
}

?>


<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table" class="product-table">
    <tr class="no-hover">
        <th class="table-header-check">S.N</th>
        <th class="table-header-repeat line-left minwidth-1">Name</th>
        <th class="table-header-repeat line-left minwidth-1">Date Added</th>
        <th class="table-header-repeat line-left">Information</th>
        <th class="table-header-repeat line-left qty">Qty</th>
        <th class="table-header-repeat line-left qty">Rem. Qty</th>
        <th class="table-header-repeat line-left minwidth-1 align-right">Cost/Unit</th>
        <!--            <th class="table-header-repeat line-left align-right mrp">MRP</th>-->
        <th class="table-header-repeat line-left minwidth-1 align-right">SOLD QTY</th>
        <th class="table-header-options line-left">Options</th>
    </tr>

    <?php

    $cid = $_GET['p'];

    if ($cid == 0 && !isset($_POST['btnCal'])) {

        ?>
        <!--<script type="text/javascript">

            $('#showForm').hide();
        </script>-->
        <?php
        $result = $mydb->getQuery('*', 'tbl_product', '1=1  ORDER BY date_added DESC', "0");

        $count = mysql_num_rows($result);
        $counter = 0;
        while ($rasProduct = $mydb->fetch_array($result)) {
            $id = $rasProduct['id'];
            $pid = $rasProduct['id'];
            $name = $rasProduct['name'];
            $date_added = $rasProduct['date_added'];
            $description = $rasProduct['description'];
            $quantity = $rasProduct['quantity'];
            $costprice = $rasProduct['costprice'];
            $mrp = $rasProduct['mrp'];
            $cid = $rasProduct['cid'];
            $sold_quantity = $rasProduct['sold_quantity'];
            $total_quantity = $sold_quantity + $quantity;

            /* echo $pid;
             echo '<br>';
             echo $cid;*/
            ?>

            <?php
            $query = "select monthname(date_added) as month, day(date_added) as day, year(date_added) as year from tbl_product where id=" . $pid;
            $date = mysql_query($query);

            $resultQuery = mysql_fetch_array($date);
            ?>
            <tr>
                <td style="text-align:center"><?php echo ++$counter; ?></td>
                <td><?php echo stripslashes($rasProduct['name']); ?></td>
                <td><?php echo stripslashes($resultQuery['day']); ?>
                    &nbsp;<?php echo stripslashes($resultQuery['month']); ?>
                    ,&nbsp; <?php echo stripslashes($resultQuery['year']); ?></td>
                <td><?php echo $rasProduct['description']; ?></td>
                <td><?php echo $total_quantity ?></td>
                <td><?php echo $rasProduct['quantity']; ?></td>
                <td class="price">Rs. <?php echo $rasProduct['costprice']; ?></td>
                <!--                    <td class="price">Rs. --><?php //echo $rasProduct['mrp']; ?><!--</td>-->
                <td class="price"><?php echo $rasProduct['sold_quantity']; ?></td>
                <td class="options-width">


                    <button href=""
                            title="Edit" class="btn-com info-tooltip" type="button"
                            onclick="editProduct('<?php echo $id; ?>','<?php echo $name; ?>','<?php echo $date_added; ?>','<?php echo $description; ?>','<?php echo $quantity; ?>','<?php echo $costprice; ?>','<?php echo $mrp; ?>','<?php echo $cid; ?>' )">
                        <i class="fa fa-edit"></i>
                    </button>
                    <a href="javascript:void(0);" title="Delete" class="info-tooltip btn-com"
                       onclick="callDeleteProduct('<?php echo $cid; ?>','<?php echo $pid; ?>');">
                        <i class="fa fa-trash"></i>
                    </a>
                    <a href="#" onclick="popupSales(<?php echo $rasProduct['id']; ?>)"
                       title="Sale" class="btn-com info-tooltip">
                        <i class="fa fa-shopping-cart"></i>
                    </a>

                </td>
            </tr>
            <?php
        }
    } elseif ($cid > 0) {
        $result = $mydb->getQuery('*', 'tbl_product', 'cid=' . $cid . ' ORDER BY date_added DESC');

        $count = mysql_num_rows($result);
        $counter = 0;
        while ($rasProduct = $mydb->fetch_array($result)) {
            $id = $rasProduct['id'];
            $pid = $rasProduct['id'];
            $name = $rasProduct['name'];
            $date_added = $rasProduct['date_added'];
            $description = $rasProduct['description'];
            $quantity = $rasProduct['quantity'];
            $costprice = $rasProduct['costprice'];
            $mrp = $rasProduct['mrp'];
            $cid = $rasProduct['cid'];
            $sold_quantity = $rasProduct['sold_quantity'];
            $total_quantity = $sold_quantity + $quantity;
            ?>

            <?php
            $query = "select monthname(date_added) as month, day(date_added) as day, year(date_added) as year from tbl_product where id=" . $pid;
            $date = mysql_query($query);

            $resultQuery = mysql_fetch_array($date);
            ?>
            <tr>
                <td style="text-align:center"><?php echo ++$counter; ?></td>
                <td><?php echo stripslashes($rasProduct['name']); ?></td>
                <td><?php echo stripslashes($resultQuery['day']); ?>
                    &nbsp;<?php echo stripslashes($resultQuery['month']); ?>
                    ,&nbsp; <?php echo stripslashes($resultQuery['year']); ?></td>
                <td><?php echo $rasProduct['description']; ?></td>
                <td><?php echo $total_quantity ?></td>
                <td><?php echo $rasProduct['quantity']; ?></td>
                <td class="price">Rs. <?php echo $rasProduct['costprice']; ?></td>
                <!--                    <td class="price">Rs. --><?php //echo $rasProduct['mrp']; ?><!--</td>-->
                <td class="price"> <?php echo $rasProduct['sold_quantity']; ?></td>
                <td class="options-width">


                    <button
                        title="Edit" class="btn-com info-tooltip" type="button"
                        onclick="editProduct('<?php echo $id; ?>','<?php echo $name; ?>','<?php echo $date_added; ?>','<?php echo $description; ?>','<?php echo $quantity; ?>','<?php echo $costprice; ?>','<?php echo $mrp; ?>','<?php echo $cid; ?>' )">
                        <i class="fa fa-edit"></i>
                    </button>
                    <a href="javascript:void(0);" title="Delete" class="info-tooltip btn-com"
                       onclick="callDeleteProduct('<?php echo $cid; ?>','<?php echo $pid; ?>');">
                        <i class="fa fa-trash"></i>
                    </a>
                    <a href="#" onclick="popupSales(<?php echo $rasProduct['id']; ?>)"
                       title="Sale" class="btn-com info-tooltip">
                        <i class="fa fa-shopping-cart"></i>
                    </a>
                </td>
            </tr>
            <?php
        }
    }

    /*if (isset($_POST['btnCal'])) {
         $from = $_POST['from'];
        //var_dump($from);
        $to = $_POST['to'];
        //$calSearch = mysql_query("select name,date_added from tbl_product where date_added BETWEEN  '$from' and '$to' ORDER by date_added DESC ") or die(mysql_query());
        $calse = $mydb->getQuery('name, date_added','tbl_product','date_added between "'.$from.'" and "'.$to.'" order by date_added desc' );

        while ($row = $mydb->fetch_array($calse))
        {
            echo $row['date_added'];
            echo $row['name'];
        }
    } */ ?>
   


