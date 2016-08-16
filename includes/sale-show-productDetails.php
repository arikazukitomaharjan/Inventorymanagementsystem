<?php
//require_once("../classes/call.php");
include("../classes/call.php");
if (isset($_POST['id'])) {
$id = $_POST['id'];

$count = $mydb->getCount('id', 'tbl_product', 'id="' . $id . '"');


    if ($count == 1) {

        $rasProduct = $mydb->getArray('id,name,quantity,costprice,mrp', 'tbl_product', 'id="' . $id . '"');
//        print_r($rasProduct);

         ?>

<!--        <input name="costprice" id="ppcost" type="hidden" value="--><?php //echo $rasProduct['costprice'];  ?><!--"/>-->
        <table width="100%" cellpadding="0" cellspacing="0" border="0" id="id-form">
            <tr>
                <th>Name :</th>
                <td><span id="pname"><?php echo $rasProduct['name']; ?></span></td>
            </tr>
            <tr>
                <th>COST PRICE :</th>

                <td><?php echo 'Rs. ' . "<span id='pcostprice'>".$rasProduct['costprice'];  "</span>"?></td>
            </tr>
            <tr>
                <th>MRP :</th>

                <td><?php echo 'Rs. ' . "<span id='pMRP'>" . $rasProduct['mrp'];
                    "</span>" ?></td>
            </tr>
            <tr>
                <th>Available Quantity :
                </td>
                <td><span id="pquantity"><?php echo $rasProduct['quantity'];  ?></span></td>
            </tr>


            <?php return  $rasProduct['quantity'];?>
        </table>

       <?php
   }
}
?>