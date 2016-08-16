<?php
/**
 * Created by PhpStorm.
 * User: sabin
 * Date: 6/2/16
 * Time: 11:33 AM
 */

include("../classes/category.class.php");
$result = $mydb->getQuery('*', 'tbl_sale', 'month(sale_date)=EXTRACT(month FROM (NOW())) AND year(sale_date) = EXTRACT(year FROM (NOW()))');
//$result = $mydb->getQuery('*', 'tbl_sale', 'month(sale_date)=EXTRACT(month FROM (NOW())) AND year(sale_date) = EXTRACT(year FROM (NOW()))');
$count = mysql_num_rows($result);
$querySum = "select sum(costprice) as totalcostprice,sum(saleprice) as totalsaleprice from tbl_sale where month(sale_date)=EXTRACT(month FROM (NOW())) AND year(sale_date) = EXTRACT(year FROM (NOW()))";

$sum = mysql_query($querySum);
$rowSum = mysql_fetch_array($sum);

//total expense
$expense = $mydb->getQuery('*', 'tbl_expense', 'month(date)=EXTRACT(month FROM (NOW())) AND year(date) = EXTRACT(year FROM (NOW())) order by date desc');
$totalExp = $mydb->getQuery('sum(cost) as cost', 'tbl_expense', 'month(date)=EXTRACT(month FROM (NOW())) AND year(date) = EXTRACT(year FROM (NOW())) order by date desc', "0");
$exp = $mydb->fetch_array($totalExp);

?>
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
   /* $q = "select pid, quantity from tbl_sale";
    $qq = mysql_query($q);
    $qqq = mysql_fetch_array($qq);
    $pid = $qqq['pid'];*/

    $sale = mysql_query("select pid,quantity from tbl_sale where id=" . $id);
    $total = mysql_fetch_array($sale);
    $saleQuantity = $total['quantity'];
    $pid=$total['pid'];

//    echo $totalQuantity;

    $select = mysql_query("select tbl_sale.remarks,tbl_product.quantity,tbl_product.sold_quantity from tbl_product join tbl_sale on tbl_sale.pid=tbl_product.id where tbl_product.id=" . $pid);
    $row = mysql_fetch_array($select);
    $quantity = $row['quantity'];

    $sold_quantity = $row['sold_quantity'];
    $productActualQuantity = $saleQuantity + $quantity;
    $productActualSoldQuantity = $sold_quantity - $saleQuantity;
    $data['quantity'] = $productActualQuantity;
    $data['sold_quantity'] = $productActualSoldQuantity;
//    echo $productActualQuantity;
//    $mydb->updateQuery('tbl_product', $productActualQuantity, 'quantity='.$productActualQuantity .'where id='.$pid );
//    mysql_query("update tbl_product set quantity=" . $productActualQuantity . "where id=" . $pid);
    $mydb->updateQuery('tbl_product', $data, 'id=' . $pid);
    $mydb->deleteQuery('tbl_sale', 'id=' . $id); //Delete the sales

    $url = ADMINURLPATH . "salesView&code=1&message=The selected Sales was deleted successfully.";
    $mydb->redirect($url);
}

?>

<script type="text/javascript">
    $('#editAlert').hide();
    function callDeleteSales(id) {


        if (confirm('Are you sure to delete ?')) {
            window.location = '?manager=salesView&id=' + id;
        }
    }
</script>


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
<form id="mainform" action="" method="post">
    <table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
        <tr>

            <td colspan="2"><a href="<?php echo ADMINURLPATH . 'category_manage&p=0'; ?>">Root > &nbsp;</a>
                <a href="<?php echo ADMINURLPATH . 'salesView'; ?>">Report > &nbsp;</a></td>
            <?php
            //                $count = count($catarr);
            //                for ($i = ($count - 1); $i >= 0; $i--) {
            //                    echo $generalObj->ahref(ADMINURLPATH . 'category_manage&p=' . $catarr[$i], $mydb->getValue('name', 'tbl_category', 'id=' . $catarr[$i])) . " > ";
            //                }

            //                $arrcount = count($catarr);

            /*   $count = count($catarr);
               for ($i = ($count - 1); $i >= 0; $i--) {
                   echo $generalObj->ahref(ADMINURLPATH . 'category_manage&p=' . $catarr[$i], $mydb->getValue('name', 'tbl_category', 'id=' . $catarr[$i])) . " > ";
               }*/

            //                $btnValue = 'Add category';
            ?>


            <td colspan="4" align="right" style="padding-right:10px;">
                <form method="post">
                    <input name="from" type="text" class="datepicker" placeholder="from" style="width: 120px !important;"
                           value="<?php echo $_POST['from']; ?>"/>
                    <input name="to" type="text" class="datepicker" placeholder="to" style="width: 120px !important;"
                           value="<?php echo $_POST['to']; ?>"/>
                    <input name="search" type="text" placeholder="Search" style="width: 120px !important;"
                           value="<?php echo $_POST['search']; ?>"/>
                    <!--                <input name="search" type="text" placeholder="Search" style="width: 120px !important;"/>-->
                    <input name="btnCal" type="submit" value="Search"/>
                </form>
            </td>


        </tr>
    </table>
    <table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">


        <tr class="no-hover">
            <th class="table-header-check">S.N</th>
            <th class="table-header-repeat line-left minwidth-1">Product Name</th>
            <th class="table-header-repeat line-left minwidth-1">Date Added</th>


            <th class="table-header-repeat line-left">Quantity</th>
            <!--            <th class="table-header-repeat line-left ">Cost Price/ quantity</th>-->
            <th class="table-header-repeat line-left ">Cost/Qty</th>
            <th class="table-header-repeat line-left">Sale/Qty</th>
            <th class="table-header-repeat line-left ">Sale Price</th>
            <th class="table-header-repeat line-left ">Profit/Loss</th>
            <th class="table-header-repeat line-left">Remarks</th>
            <th class="table-header-options line-left">Options</th>
        </tr>


        <?php
        $from = $_POST['from'];
        //var_dump($from);
        $to = $_POST['to'];
        $search = $_POST['search'];

        $counter = 0;
        if (isset($_POST['btnCal'])) {
            if ($from != "" && $to != "" && $search == "") {
                // echo "2";
                $calSearch = mysql_query("select tbl_sale.id,tbl_sale.sale_date,tbl_sale.sale_datetime,tbl_sale.saleprice,tbl_sale.costprice,tbl_sale.quantity,tbl_product.name from tbl_sale join tbl_product on tbl_sale.pid=tbl_product.id where (sale_date BETWEEN  '$from' and '$to') ORDER by sale_date DESC") or die(mysql_query());

                $sql = mysql_query("select sum(costprice) as costprice,sum(saleprice) as saleprice from tbl_sale where (sale_date BETWEEN  '$from' and '$to') ORDER by sale_date DESC");
                $ress = mysql_fetch_array($sql);
            }
            if ($from != "" && $to != "" && $search != "") {
//print_r("select * from tbl_product where (date_added BETWEEN  '$from' and '$to') or name like '%$search%' or description like '%$search%' or quantity like %$search% or costprice like %$search% or mrp like %$search% ORDER by date_added DESC");
                $calSearch = mysql_query("select tbl_sale.id,tbl_sale.sale_date,tbl_sale.sale_datetime,tbl_sale.saleprice,tbl_sale.costprice,tbl_sale.quantity,tbl_product.name from tbl_sale join tbl_product on tbl_sale.pid=tbl_product.id where (sale_date BETWEEN  '$from' and '$to') and( tbl_product.name like '%$search%') ORDER by sale_date DESC");

                $sql = mysql_query("select sum(tbl_sale.costprice) as costprice,sum(tbl_sale.saleprice) as saleprice from tbl_sale join tbl_product on tbl_sale.pid=tbl_product.id where (tbl_sale.sale_date BETWEEN  '$from' and '$to') and( tbl_product.name like '%$search%') ORDER by sale_date DESC");
                $ress = mysql_fetch_array($sql);
            }

            if ($from == "" && $to == "" && $search != "") {
                //print_r("select * from tbl_product where name like ''%$search%''  ORDER by date_added DESC");
                //print_r("select * from tbl_product where name like '%$search%' or description like '%$search%' or quantity like %$search% or costprice like %$search% or mrp like %$search% ORDER by date_added DESC");
//                $calSearch = mysql_query("select * from tbl_sale where pid like '%$search%' or costprice like '%$search%' or saleprice like '%$search%' ORDER by date_added DESC") or die(mysql_query());
                $calSearch = mysql_query("select tbl_sale.id,tbl_sale.sale_date,tbl_sale.sale_datetime,tbl_sale.saleprice,tbl_sale.costprice,tbl_sale.quantity,tbl_product.name from tbl_sale join tbl_product on tbl_sale.pid=tbl_product.id where (tbl_product.name like '%$search%') ORDER by sale_date DESC") or die(mysql_query());

                $sql = mysql_query("select sum(tbl_sale.costprice) as costprice,sum(tbl_sale.saleprice) as saleprice from tbl_sale join tbl_product on tbl_sale.pid=tbl_product.id where(tbl_product.name like '%$search%') ORDER by sale_date DESC");
                $ress = mysql_fetch_array($sql);
            }
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
            }
//            while ($row = mysql_fetch_array($calSearch)) {

            //between date sales price


            //between date expense
//            $calSearch = mysql_query("select * from tbl_sale where (sale_date BETWEEN  '$from' and '$to') ORDER by sale_date DESC") or die(mysql_query());
            $expSearch = mysql_query("select sum(cost) as cost from tbl_expense where (date BETWEEN  '$from' and '$to') ORDER by date DESC") or die(mysql_query());

            $expSearchs = mysql_fetch_array($expSearch);

            $totalexps = $expSearchs['cost'];
            while ($row = $mydb->fetch_array($calSearch)) {
                ?>
                <tr>

                    <td style="text-align:center"><?php echo ++$counter; ?></td>


                    <?php

                    $pid = $row['pid'];
                    $id = $row['id'];
                    $profit = $row['saleprice'] - $row['costprice'];
                    $loss = $row['costprice'] - $row['saleprice'];
                    $result1 = $mydb->getQuery('id,name,description', 'tbl_product', 'id="' . $pid . '"');
                    //                echo "parent_id=" . $pid;
                    $count = mysql_num_rows($result1);
                    //                echo "count=" . $count;
                    $res1 = $mydb->fetch_array($result1);
                    //                echo $res1['name'];
                    ?>

                    <?php
                    $query = "select monthname(sale_date) as month, day(sale_date) as day, year(sale_date) as year from tbl_sale where id=" . $id;
                    $date = mysql_query($query);
                    $salePerQuantity = round(($row['saleprice'] / $row['quantity']), 2);
                    $CostPerQuantity = round(($row['costprice'] / $row['quantity']), 2);

                    //print_r( $query) ;
                    $resultQuery = mysql_fetch_array($date);
                    $name = $row['name'];
                    $orginalname = $res1['name'];
                    ?>
                    <!--                --><?php //echo $id = $row['id']; ?>
                   <!-- <td><?php /*if ($orginalname)
                            echo $originalname;
                        else
                            echo $name; */?></td>-->

                   <?php $data=$originalname?$originalname:$name ?>
                    <td><?php echo $data; ?></td>
                    <td><?php echo stripslashes($resultQuery['day']); ?>
                        &nbsp;<?php echo stripslashes($resultQuery['month']); ?>
                        ,&nbsp; <?php echo stripslashes($resultQuery['year']); ?></td>

                    <td><?php echo $row['quantity']; ?></td>
                    <!--                    <td>--><?php //echo $CostPerQuantity; ?><!--</td>-->
                    <td>Rs. <?php echo $CostPerQuantity ?></td>
                    <td>Rs. <?php echo $salePerQuantity ?></td>
                    <td>Rs. <?php echo round(($row['saleprice']), 2); ?></td>
                    <td><?php if ($row['saleprice'] > $row['costprice']) {
                            ?>
                            <?php echo 'profit:' . $profit; ?>
                        <?php } elseif ($row['saleprice'] < $row['costprice']) { ?>

                            <?php echo 'loss' . $loss; ?>
                        <?php } elseif ($row['saleprice'] == $row['costprice']) { ?>

                            <?php echo '0'; ?>
                        <?php } ?></td>
                    <td><?php echo $row['remarks']; ?></td>
                    <td><a href="javascript:void(0);" title="Delete" class="icon-2 info-tooltip"
                           onclick="callDeleteSales('<?php echo $id; ?>');"></a></td>
                </tr>


                <?php
            }
            ?>
            <?php
            /*$costprice = $row['costprice'];
            $saleprice = $row['saleprice'];
            */

            //                                    $querySum = $mydb->getArray('sum($costprice]),sum($saleprice)', 'tbl_sale');
            ?>
            <tr>
                <td colspan="9" class=" align-right">Total Sale price:</td>

                <td> Rs. <?php echo round($ress['saleprice']); ?></td>
            </tr>
            <tr>


                <td colspan="9" class=" align-right">Total Cost price:</td>

                <td> Rs. <?php echo round($ress['costprice']); ?></td>
            </tr>


            <tr>
                <td colspan="9" class=" align-right">Total Expense:

                </td>
                <td>


                    <?php if ($totalexps == "") {
                        ?>
                        Rs. 0
                    <?php } else { ?>
                        Rs. <?php echo $totalexps; ?>
                    <?php } ?>

                </td>
            </tr>
            <tr>

                </td>
                <?php if ($ress['saleprice'] > ($ress['costprice'] + $totalexps)) {
                    $profit = $ress['saleprice'] - $ress['costprice'] - $totalexps;
                    ?>
                    <td colspan="9" class=" align-right">Profit:</td>
                    <td>Rs. <?php echo round($profit, 2); ?></td>
                <?php } ?>
                <?php if ($ress['saleprice'] < ($ress['costprice'] + $totalexps)) {
                    $loss = ($ress['costprice'] + $totalexps) - $ress['saleprice']; ?>
                    <td colspan="9" class=" align-right">Loss:</td>
                    <td>Rs. <?php echo round($loss, 2); ?></td>
                <?php } ?>

            </tr>
            <?php
        } else {
// if between date is not performed
            while ($row = $mydb->fetch_array($result)) {
                ?>
                <?php
                $id = $row['id'];
                $profit = $row['saleprice'] - $row['costprice'];

                $loss = $row['costprice'] - $row['saleprice'];

                $query = "select monthname(sale_date) as month, day(sale_date) as day, year(sale_date) as year from tbl_sale where id=" . $id;
                $date = mysql_query($query);

                $resultQuery = mysql_fetch_array($date);
                ?>
                <tr>

                <td style="text-align:center"><?php echo ++$counter; ?></td>


                <?php

                $pid = $row['pid'];
                $result1 = $mydb->getQuery('id,name,description', 'tbl_product', 'id="' . $pid . '"');
                //                echo "parent_id=" . $pid;
                $count = mysql_num_rows($result1);
                //                echo "count=" . $count;
                $res1 = $mydb->fetch_array($result1);
                //                echo $res1['name'];
                ?>

                <?php
                $query = "select monthname(sale_date) as month, day(sale_date) as day, year(sale_date) as year from tbl_sale where id=" . $id;
                $date = mysql_query($query);
                //print_r( $query) ;
                $salePerQuantity = round(($row['saleprice'] / $row['quantity']), 2);
                $CostPerQuantity = round(($row['costprice'] / $row['quantity']), 2);

                $resultQuery = mysql_fetch_array($date);
                ?>
                <!--                --><?php //echo $id = $row['id']; ?>

                <td><?php echo $res1['name']; ?></td>
                <td><?php echo stripslashes($resultQuery['day']); ?>
                    &nbsp;<?php echo stripslashes($resultQuery['month']); ?>
                    ,&nbsp; <?php echo stripslashes($resultQuery['year']); ?></td>

                <td><?php echo $row['quantity']; ?></td>
                <!--                <td>--><?php //echo $CostPerQuantity; ?><!--</td>-->
                <td>Rs. <?php echo $CostPerQuantity; ?></td>
                <td>Rs. <?php echo $salePerQuantity; ?></td>
                <td>Rs. <?php echo round(($row['saleprice']), 2); ?></td>
                <td><?php if ($row['saleprice'] > $row['costprice']) {
                        ?>
                        <?php echo 'profit:' . $profit; ?>
                    <?php } elseif ($row['saleprice'] < $row['costprice']) { ?>

                        <?php echo 'loss' . $loss; ?>
                    <?php } elseif ($row['saleprice'] == $row['costprice']) { ?>

                        <?php echo '0'; ?>
                    <?php } ?></td>

                <td><?php echo $row['remarks']; ?></td>

                <td><a href="javascript:void(0);" title="Delete" class="icon-2 info-tooltip"
                       onclick="callDeleteSales('<?php echo $row['id']; ?>');"></a></td>


                <?php
            }
            ?>
            <tr>
                <td colspan="9" class=" align-right">Total Sale price:</td>
                <td>Rs. <?php echo round($rowSum['totalsaleprice'], 2); ?></td>
            </tr>
            <tr>
                <td colspan="9" class=" align-right">Total Cost price:</td>
                <td>Rs. <?php echo round($rowSum['totalcostprice']); ?></td>
            </tr>


            <tr>
                <td colspan="9" class=" align-right">Total Expense:</td>
                <td><?php if ($exp['cost'] == "") {
                        ?>
                        Rs. 0
                    <?php } else { ?>

                        Rs. <?php echo $exp['cost']; ?>
                    <?php } ?></td>
            </tr>
            <tr>


                <?php if ($rowSum['totalsaleprice'] > ($rowSum['totalcostprice'] + $exp['cost'])) {
                    $profit = $rowSum['totalsaleprice'] - $rowSum['totalcostprice'] - $exp['cost']; ?>

                    <td colspan="9" class=" align-right">Profit:</td>
                    <td>Rs. <?php echo round($profit, 2); ?></td>
                <?php } ?>
                <?php if ($rowSum['totalsaleprice'] < ($rowSum['totalcostprice'] + $exp['cost'])) {
                    $loss = ($rowSum['totalcostprice'] + $exp['cost']) - $rowSum['totalsaleprice']; ?>
                    <td colspan="9" class=" align-right">Loss:</td>
                    <td>Rs. <?php echo round($loss, 2); ?></td>
                <?php } ?>

            </tr>

            <?php
        } ?>


    </table>

</form>

