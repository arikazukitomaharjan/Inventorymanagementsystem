<?php
include("../classes/category.class.php");
if (isset($_GET['p'])) {
    $parent_id = $_GET['p'];
} else {
    $parent_id = '0';
}
$cid = $parent_id;

$catarr[] = $parent_id;
while ($parent_id1 != 0) {
    $parent_id1 = $menuObj->getParentId($parent_id1);
    $catarr[] = $parent_id1;
}

if (count($catarr) > 1) {
    $cid = $catarr['1'];

} else {
    $cid = $_GET['p'];

}
?>
<!--
<LINK href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<Script src="js/bootstrap.min.js" type="text/javascript"/>-->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td><!-- menu -->

            <?php include "category_list.php"; ?>
        </td>
    </tr>
    <tr>
        <td><!-- PRODUCTS -->
            <?php include "product_list.php"; ?></td>
    </tr>
</table>

<script>
    $('#showMsg').hide();
    function addExpense() {
        $('#showExpenseAlert').hide();
        $('#addExpense').modal('show');

    }
    function addCategory() {
        $('#showCategoryAlert').hide();
        $('#addCategory').modal('show');

    }

    function saveCategory() {
        $name = $('#name').val();
        $description = $('#description').val();
        if($name==""){
            alert('please insert name field');
            return false;
        }
        data = {
            'name': $name,
            'description': $description
        };
        $.ajax({
            url: "includes/save_category.php",
            method: 'POST',
            data: data,
            success: function (result) {

                var tm = 0;
                setInterval(function () {
                    // Do something every 5 seconds
                    if (tm == 1) {


                        $('#showCategoryAlert').show();
                    }

                    if (tm == 500) {

                        $('#showCategoryAlert').hide();
                    }

                    tm = tm + 1;
                }, 1);
            }
        });


    }
    function saveExpense() {
        $name = $('#name').val();
        $description = $('#description').val();
        $cost = $('#cost').val();
        $date = $('#date').val();
        if($name=="" && $cost==""){
            alert('please insert name field');
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

    function saveProduct() {
        $date_added = $('#date_added').val();
        $name = $('#names').val();

        $description = $('#descriptions').val();

        $quantity = $('#quantity').val();
        $costprice = $('#costprices').val();
        $mrp = $('#mrp').val();
        $cid = parseInt($('#cids').val());

        if($name=="" && $quantity=="" ){
            alert('please insert name and quantity field');
            return false;
        }
//        $cid=$('#aa:selected').attr("id")
        var data = {
            'date_added': $date_added,
            'name': $name,
            'description': $description,
            'quantity': $quantity,
            'costprice': $costprice,
            'mrp': $mrp,
            'cid': $cid
        };
        console.log(data);
//        $('#productModal').modal('show');


        var tm = 0;
        setInterval(function () {
            // Do something every 5 seconds
            if (tm == 1) {
                $('#imgSpin').show();
            }

            if (tm == 200) {
                $('#imgSpin').hide();
            }

            tm = tm + 1;
        }, 1);
        $.ajax({
            url: "includes/save_product.php",
            type: 'POST',
            data: data,
            success: function (result) {
                console.log(result);
//                <img src="../img/spinner.gif">
                var tm = 0;
                setInterval(function () {
                    // Do something every 5 seconds
                    if (tm == 1) {


                        $('#showAlert').show();
                    }

                    if (tm == 500) {

                        $('#showAlert').hide();
                    }

                    tm = tm + 1;
                }, 1);


            }
        });


    }


    function editProduct(id, name, date_added, description, quantity, costprice, mrp, cid) {

        $id = $('#idproductssss').val(id);
        $date_added = $('#date_addedproduct').val(date_added);


        $name = $('#nameproduct').val(name);

        $description = $('#descriptionproduct').val(description);

        $quantity = $('#quantityproduct').val(quantity);
        $costprice = $('#costpriceproduct').val(costprice);
        $mrp = $('#mrpproduct').val(mrp);
        $cid = parseInt($('#cidproduct').val(cid));

        $('#editProductModal').modal('show');

    }
    function popupSales(id) {

//        $('#showHere').load("includes/sale-show-productDetails.php", {'id': id});\
        console.log('hello');

        $('#salesID').val(id);
        $.ajax({
            url: "includes/sale-show-productDetails.php",
            type: 'POST',
            data: {'id': id},
            success: function (result) {

                console.log(result);

                var pcost = $(result).find('#pcostprice').text();

                var pMRP = $(result).find('#pMRP').text();
                var pquantity = $(result).find('#pquantity').text();

//              $('#ppname').text(pname);
                $('#showResult').html(result);
                $('#ppMRP').text(pMRP);
                var a = $('#ppMRP').text();
                $('#ppcostprice').text(pcost);
                var ppcostprice = $('#ppcostprice').text();

                console.log("cost _d=" + ppcostprice);
                var b = $('#qty').val();
                console.log(b);
                // $('#ppquantity').text(pquantity);

                $('#qty').keyup(function () {
                    var cost = $('#ppMRP').text();
                    var costprice = $('#ppcostprice').text();
//                    console.log('cosdfsadfsa' + costprice);
//                    console.log(costprice);
                    var quan = $('#qty').val();
//                    $(data).find('#title').text()
//                    var a= $('#pquantity').val();
                    //var press=$('qty').val();
                    var totalcost = cost * quan;
                    var actual = costprice * quan;
//                    console.log("dfsadas"+actual);
//                    var tot = $('#showPrices').val(totalcost);
                    $('#ss').html(totalcost);
                    $('#cs').html(actual);
                    console.log("mrp" + totalcost + "cs" + actual);

                    var mrp = $('#ss').text();
                    console.log('s' + mrp);
                    $('#saleprice').val(mrp);
                    var cos = $('#cs').text();
                    console.log('s' + cos);
                    $('#costprice').val(cos);
                    /*console.log(totalcost);
                     console.log("cost=" + cost + "sale" + quan + "c=" + actual);*/

                });
                $('#total_sale_prices').keyup(function () {
                    var amount = $('#total_sale_prices').val();
                    var quan = $('#qty').val();
                    var amount_per_item = amount / quan;
                    $('#amount_per_item').val(amount_per_item);
                    console.log("aaaaaaaaaaaaaaaaaaaaaaaaaaa" + amount_per_item);
                });
                /*$('#amount_per_item').keyup(function () {
                 var amount = $('#amount_per_item').val();
                 var quan = $('#qty').val();
                 var total_sale_amount = amount * quan;
                 $('#total_sale_prices').val(total_sale_amount);
                 console.log("aaaaaaaaaaaaaaaaaaaaaaaaaaa" + total_sale_amount);
                 });*/

            }

        });


//        var currentId = $(this).attr('id');
//        var id  = getFieldElements('id').val();
        $('#myModal').modal('show');
    }


    function popupProduct() {
        $('#showAlert').hide();
        $('#imgSpin').hide();
        $('#productModal').modal('show');

    }
    /* $('#productModal').modal({
     backdrop: 'static',
     keyboard: false
     });*/

</script>

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

                    <input type="date" class="form-control tcal" id="date" class="datepicker" name="date"
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
