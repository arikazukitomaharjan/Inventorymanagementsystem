<script>
    $('#editAlert').hide();
</script>
<?php
/**
 * Created by PhpStorm.
 * User: sabin
 * Date: 6/15/16
 * Time: 11:21 AM
 */
include("../classes/category.class.php");

$id = $_GET['id'];

if (isset($_POST['btnupdate'])){
    $data="";
    $id=$_POST['id'];
    $data['name']=$_POST['name'];
    $data['description']=$_POST['description'];
    $data['cost']=$_POST['cost'];
    $data['date']=$_POST['date'];
    $mess=$mydb->updateQuery('tbl_expense', $data, 'id='.$id);
    $url=   ADMINURLPATH."expense&code=1&message=".$mess;
    $mydb->redirect($url);


}


//expense
$expense = $mydb->getQuery('*', 'tbl_expense', 'month(date)=EXTRACT(month FROM (NOW())) AND year(date) = EXTRACT(year FROM (NOW())) order by date desc');
$totalExp = $mydb->getQuery('sum(cost) as cost', 'tbl_expense', 'month(date)=EXTRACT(month FROM (NOW())) AND year(date) = EXTRACT(year FROM (NOW())) order by date desc', "0");
$exp = $mydb->fetch_array($totalExp);


//sales view
$totalSale = $mydb->getQuery('sum(saleprice) as totalsaleprice,sum(costprice) as totalcostprice', 'tbl_sale', 'month(sale_date)=EXTRACT(month FROM (NOW())) AND year(sale_date) = EXTRACT(year FROM (NOW())) order by sale_date desc', "0");
$rowSalePrice = $mydb->fetch_array($totalSale);

$ts = $rowSalePrice['totalsaleprice'];

?>
<script type="application/javascript">

    function callDeleteExpense(id) {


        if (confirm('Are you sure to delete ?')) {
            window.location = '?manager=expense&id=' + id;
        }
    }

    function addExpense() {
        $('#showExpenseAlert').hide();
        $('#addExpense').modal('show');

    }

    function saveExpense() {
        $name = $('#name').val();
        $description = $('#description').val();
        $cost = $('#cost').val();
        $date = $('#date').val();
        if($name=="" && $cost ==""){
            alert('please insert name and cost');
            return false;
        }
        data = {
            'name': $name,
            'description': $description,
            'cost': $cost,
            'date': $date
        };
        $.ajax({
            url: "includes/save_expense.php",
            method: 'POST',
            data: data,
            success: function (result) {
                var tm = 0;
                setInterval(function () {
                    // Do something every 5 seconds
                    if (tm == 1) {


                        $('#showExpenseAlert').show();
                    }

                    if (tm == 500) {

                        $('#showExpenseAlert').hide();
                    }

                    tm = tm + 1;
                }, 1);
            }
        });


    }
    function editExpense(id, name, description,date,cost) {

        $('#idss').val(id);
        $('#namessss').val(name);
        $('#descriptions').val(description);
        $('#dates').val(date);
        $('#costs').val(cost);
        $('#editPopExpense').modal('show');
    }

</script>

<?php
//add query
if (isset($_POST['btnAdd'])) {
    $data = "";
    $data['name'] = $_POST['name'];
    $data['description'] = $_POST['description'];
    $data['cost'] = $_POST['cost'];
    $data['date'] = $_POST['date'];
    $data['userid'] = $_SESSION[ADMINUSER];
    $mess = $mydb->insertQuery('tbl_expense', $data);
    $url = ADMINURLPATH . "expense&code=1&message=" . $mess;
    $mydb->redirect($url);
}

//delete query
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $mess = $mydb->deleteQuery('tbl_expense', 'id=' . $id);
    $url = ADMINURLPATH . "expense&sid=" . $id . "&code=1&message=" . $mess;
    $mydb->redirect($url);
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

                $btnValue = 'Add category';
                ?>

            <td>
            <td colspan="4" align="right" style="padding-right:10px;">

                <input name="from" type="text" class="datepicker" placeholder="from" style="width: 120px !important;" value="<?php echo $_POST['from']; ?>"/>
                <input name="to" type="text" class="datepicker" placeholder="to" style="width: 120px !important;" value="<?php echo $_POST['to']; ?>"/>
                <!--                <input name="search" type="text" placeholder="Search" style="width: 120px !important;"/>-->
                <input name="btnCal" type="submit" value="Search"/>

            </td>
            <td>
                <button type="button" name="expense" onclick="addExpense()">
                    add Expense
                </button>
            </td>
        </tr>
    </table>
</form>


<?php
if (isset($_POST['btnCal'])) {
    $from = $_POST['from'];
    $to = $_POST['to'];

    if ($from != "" && $to != "") {
        // echo "2";
        $calSearch = mysql_query("select * from tbl_expense where (date BETWEEN  '$from' and '$to') ORDER by date DESC") or die(mysql_query());
        $calSearchSale = mysql_query("select * from tbl_sale where (sale_date BETWEEN  '$from' and '$to') ORDER by sale_date DESC") or die(mysql_query());
    }

    $expSearch = mysql_query("select sum(cost) as cost from tbl_expense where (date BETWEEN  '$from' and '$to') ORDER by date DESC") or die(mysql_query());
    $expSearchSale = mysql_query("select sum(costprice) as costprice,sum(saleprice) as saleprice from tbl_sale where (sale_date BETWEEN  '$from' and '$to') ORDER by sale_date DESC") or die(mysql_query());

    $expSearchs = mysql_fetch_array($expSearch);
    $totalexps = $expSearchs['cost'];
    $expSearchsales = mysql_fetch_array($expSearchSale);
    $totalsales = $expSearchsales['saleprice'];
    $totalcost = $expSearchsales['costprice'];

    ?>


    <form action="" method="post" name="productOrdering" id="showForm ">
        <table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table" class="product-table">
            <tr class="no-hover">
                <th class="table-header-check">S.N</th>
                <th class="table-header-repeat line-left minwidth-1">Name</th>
                <th class="table-header-repeat line-left minwidth-1">Description</th>
                <th class="table-header-repeat line-left">Cost</th>
                <th class="table-header-repeat line-left">Date</th>
                <th class="table-header-options line-left">Options</th>
            </tr>
            <tr>
                <?php
                $counter = 0;
                while ($row = mysql_fetch_array($calSearch)){
                $id=$row['id'];
                $query = "select monthname(date) as month, day(date) as day, year(date) as year from tbl_expense where id=" . $id;
                $date = mysql_query($query);
                $resultQuery = mysql_fetch_array($date);
                ?>
            <tr>
                <td><?php echo ++$counter; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['cost']; ?></td>
                <td><?php echo stripslashes($resultQuery['day']); ?>
                    &nbsp;<?php echo stripslashes($resultQuery['month']); ?>
                    ,&nbsp; <?php echo stripslashes($resultQuery['year']); ?></td>

                <td>
                    <button
                        title="Edit" class="btn-com info-tooltip"
                        onclick="editExpense( '<?php echo $row['id']; ?>','<?php echo $row['name']; ?>','<?php echo $row['description']; ?>','<?php echo $row['date']; ?>','<?php echo $row['cost']; ?>')">
                        <i class="fa fa-edit"></i>
                    </button>
                    <a href="javascript:void(0);" title="Delete" class="info-tooltip btn-com"
                       onclick="callDeleteExpense('<?php echo $row["id"]; ?>');">
                        <i class="fa fa-trash"></i>
                    </a>

                </td>
            </tr>

            <?php
            }
            ?>
            </tr>
           <!-- <tr>
                <td colspan="5" class=" align-right">Total Cost:</td>
                <td> <?php /*echo $totalcost */?></td>
            </tr>
            <tr>
                <td colspan="5" class=" align-right">Total Sales:</td>
                <td> <?php /*echo $totalsales; */?></td>
            </tr>-->
            <tr>
                <td colspan="5" class=" align-right">Total Expenses:</td>
                <td> <?php echo $totalexps; ?></td>
            </tr>
            <!--<tr>
                <?php
/*                $tc = $exp['cost'];
                if ($totalexps < $totalsales) {
                $profit = $totalsales - $totalexps;
                */?>
                <td colspan="5" class=" align-right">Profit:</td>
                <td> <?php /*echo $profit; */?></td>
                <?php /*}else {
                    $loss = $totalexps - $totalsales;
                */?>
                <td colspan="5" class=" align-right">Loss :</td>
                <td> <?php /*echo $loss; */?></td>
                <?php /*} */?>

            </tr>-->



        </table>
    </form>

<?php } else {

    ?>


    <table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
        <?php if (isset($_GET['message'])) {
            if (isset($_GET['code']) && $_GET['code'] == 1) $ccode = 'green';
            else  $ccode = 'red';
        }
        ?>

        <tr class="no-hover">
            <th class="table-header-check">S.N</th>
            <th class="table-header-repeat line-left minwidth-1">Name</th>
            <th class="table-header-repeat line-left minwidth-1">Description</th>
            <th class="table-header-repeat line-left">Cost</th>

            <th class="table-header-repeat line-left">Date</th>


            <th class="table-header-options line-left">Options</th>
        </tr>
        <?php
        $counter = 0;

        while ($row = $mydb->fetch_array($expense)) {
            $id=$row['id'];
            $query = "select monthname(date) as month, day(date) as day, year(date) as year from tbl_expense where id=" . $id;
            $date = mysql_query($query);
            $resultQuery = mysql_fetch_array($date);
            ?>
            <tr>
                <td><?php echo ++$counter; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['cost']; ?></td>
                <td><?php echo stripslashes($resultQuery['day']); ?>
                    &nbsp;<?php echo stripslashes($resultQuery['month']); ?>
                    ,&nbsp; <?php echo stripslashes($resultQuery['year']); ?></td>

                <td>
                    <button
                        title="Edit" class="btn-com info-tooltip"
                        onclick="editExpense( '<?php echo $row['id']; ?>','<?php echo $row['name']; ?>','<?php echo $row['description']; ?>','<?php echo $row['date']; ?>','<?php echo $row['cost']; ?>')">
                        <i class="fa fa-edit"></i>
                    </button>
                    <a href="javascript:void(0);" title="Delete" class="info-tooltip btn-com"
                       onclick="callDeleteExpense('<?php echo $row["id"]; ?>');">
                        <i class="fa fa-trash"></i>
                    </a>

                </td>
            </tr>

            <?php
        }
        ?>

       <!-- <tr>
            <td colspan="5" class=" align-right">Total Cost:</td>
            <td> <?php /*echo $rowSalePrice['totalcostprice']; */?></td>
        </tr>
        <tr>
            <td colspan="5" class=" align-right">Total Sales:</td>
            <td> <?php /*echo $rowSalePrice['totalsaleprice']; */?></td>
        </tr>-->
        <tr>
            <td colspan="5" class=" align-right">Total Expenses :</td>
           <?php if($exp['cost']==""){
            ?>
            <td> 0 </td>
            <?php }else{?>

            <td> <?php echo $exp['cost']; ?></td>
           <?php }?>
        </tr>



    </table>
    
    <?php

} ?>
<!-- Modal -->
<div class="modal fade" id="addExpense" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4>Expense</h4>

            </div>
            <div class="modal-body">

                <div id="showExpenseAlert">
                    <div class="alert alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <span id="showMsg">Expense was successfully added</span>
                    </div>
                </div>

                    <div class="form-group">
                        <label for="name">name</label>
                        <input type="text" class="form-control " id="name" name="name"
                               placeholder="Name" width="50px">
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="textarea" class="form-control " id="description" name="description"
                               placeholder="description">
                    </div>
                    <div class="form-group">
                        <label for="cost">Cost</label>
                        <input type="number" class="form-control " id="cost" name="cost"
                               placeholder="Cost">
                    </div>
                    <div class="form-group">

                        <input type="date" class="form-control tcal" id="date" name="date"
                               placeholder="" value="<?php echo date('Y-m-d') ?>">

                    </div>



                <input name="btnAddExpense" id="addExpense" type="submit" value="Submit" onclick="saveExpense()"
                       class="button"/>


            </div>



        </div>
        <!-- <div class="modal-footer">
             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
             <button type="button" class="btn btn-primary">sale</button>
         </div>-->
    </div>
</div>


<div class="modal fade" id="editPopExpense" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4>Edit Expense</h4>

            </div>
            <div class="modal-body">

                <form name="form1" method="post" action="">
                    <table width="100%">

                        <tr>

                            <td><input type="hidden" name="id" id="idss"
                                /></td>
                        </tr>
                        <tr>
                            <th width="15%">Name:</th>
                            <td><input type="text" name="name" id="namessss"
                                /></td>
                        </tr>
                        <tr>
                            <th valign="top">Description:</th>
                            <td><textarea name="description" id="descriptions" cols="" rows=""
                                          class="form-textarea"></textarea></td>
                        </tr>
                          <tr>
                            <th valign="top">Cost:</th>
                            <td><input type="text" name="cost" id="costs"
                                          ></td>
                        </tr>
                          <tr>
                            <th valign="top">Date:</th>
                              <td><input type="text" name="date" id="dates"
                                  /></td>
                        </tr>


                        <tr>
                            <td>&nbsp;</td>
                            <td><input name="btnupdate" type="submit" value="Update" class="button" onMouseOut="this.className='button'"
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