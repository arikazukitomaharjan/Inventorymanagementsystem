<?php
/**
 * Created by PhpStorm.
 * User: sabin
 * Date: 7/6/16
 * Time: 12:34 PM
 */

include("../classes/category.class.php");
include("../classes/createthumbnail.php");
if (isset($_POST['btnDo'])) {
    // for ($i = 1; $i < 4; $i++){
    //     $originalDate = $_POST['date_added'];
    //     $newDate = date("Y-m-d", strtotime($originalDate));
    //     $data['date_added'] = $newDate;
    //     $data['name'] = $_POST['name'];
    //     $data['description'] = $_POST['description'];
    //     $data['quantity'] = $_POST['quantity'];
    //     $data['costprice'] = $_POST['costprice'];
    //     $data['mrp'] = $_POST['mrp'];
    //     $data['cid'] = (int)$_POST['cid'];
    //     for ($i = 0; $i < count($name_array); $i++) {

    //     $name = mysql_real_escape_string($name_array[$i]);
    //     $age = mysql_real_escape_string($age_array[$i]);

    //     mysql_query("INSERT INTO users (name, age) VALUES ('$name', '$age')");
    //     } 

    //     $pid = $mydb->insertQuery('tbl_product', $data);
    // }
    if ( !empty($_POST['name']) && is_array($_POST['name']) ) {
        $dateAdded = $_POST['date_added'];
        $name_array = $_POST['name'];
        $desc_array = $_POST['description'];
        $qty_array = $_POST['quantity'];
        $costPrice_array = $_POST['costprice'];
        $categoryID = $_POST['cid'];
//        $mrp_array = $_POST['mrp'];
        // $name_array = $_POST['cid'];
        for ($i = 0; $i < count($name_array); $i++) {

            $data['date_added'] = $dateAdded;
            $data['name'] = $name_array[$i];
            $data['description'] = $desc_array[$i];
            $data['quantity'] = $qty_array[$i];
            $data['costprice'] = $costPrice_array[$i];
            $data['cid'] = $categoryID[$i];
            $data['mrp'] =0;
            // echo "<pre>";
            // print_r($data);
            // echo "</pre><br>";
            if( $name_array[$i] != ""){
                $pid = $mydb->insertQuery('tbl_product', $data);
            }
            
        } 
        
    }
}
?>

<form name="productInsert" method="post" action="" enctype="multipart/form-data" id="mainform">
<label>Date Added: </label>
 
<input name="date_added" type="text" value="<?php echo date('Y-m-d'); ?>" placeholder="added date"/>
    <table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table" class="product-table">
        <tr class="no-hover">

            <th class="table-header-repeat line-left minwidth-1">Name</th>
            <th class="table-header-repeat line-left minwidth-1">Category</th>
            <th class="table-header-repeat line-left maxwidth-1" width="1" style="width: 2px;">Information</th>
            <th class="table-header-repeat line-left qty ">Qty</th>
            <th class="table-header-repeat line-left minwidth-1 align-right">Cost/Unit</th>
            <!--                <th class="table-header-repeat line-left align-right mrp">MRP</th>-->
        </tr>

<?php  for($j=0;$j<10;$j++){?>
        <tr>


            <td><input name="name[]" type="text" placeholder="name" class="inp-form"/></td>
            <td>
                <select name="cid[]" id="cid" class="styledselectbox">
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

            <td><textarea name="description[]" id="description" cols="60" rows="7" placeholder="information"
                          class="form-textarea"></textarea></td>
            <td><input name="quantity[]" id="quantity" type="text" placeholder="quantity"
                       class="inp-form"/></td>
            <td><input name="costprice[]" id="costprice" type="text" placeholder="costprice"
                       class="inp-form"/></td>

        </tr>
        <?php }?>
        

        <tr>

            <td style="padding-bottom:15px;"><input name="btnDo" type="submit" value="Add"
                                                    class="button"/></td>
        </tr>

    </table>
</form>

