<script type="text/javascript" charset="utf-8">
    $(function () {

// initialise the "Select date" link
        $('#date-pick')
            .datePicker(
                // associate the link with a date picker
                {
                    createButton: false,
                    startDate: '01/01/2005',
                    endDate: '31/12/2020'
                }
            ).bind(
            // when the link is clicked display the date picker
            'click',
            function () {
                updateSelects($(this).dpGetSelected()[0]);
                $(this).dpDisplay();
                return false;
            }
        ).bind(
            // when a date is selected update the SELECTs
            'dateSelected',
            function (e, selectedDate, $td, state) {
                updateSelects(selectedDate);
            }
        ).bind(
            'dpClosed',
            function (e, selected) {
                updateSelects(selected[0]);
            }
        );

        var updateSelects = function (selectedDate) {
            var selectedDate = new Date(selectedDate);
            $('#d option[value=' + selectedDate.getDate() + ']').attr('selected', 'selected');
            $('#m option[value=' + (selectedDate.getMonth() + 1) + ']').attr('selected', 'selected');
            $('#y option[value=' + (selectedDate.getFullYear()) + ']').attr('selected', 'selected');
        }
// listen for when the selects are changed and update the picker
        $('#d, #m, #y')
            .bind(
                'change',
                function () {
                    var d = new Date(
                        $('#y').val(),
                        $('#m').val() - 1,
                        $('#d').val()
                    );
                    $('#date-pick').dpSetSelected(d.asString());
                }
            );

// default the position of the selects to today
//var today = new Date();
//updateSelects(today.getTime());

// and update the datePicker to reflect it...
//$('#d').trigger('change');
    });
</script>
<script type="text/javascript">
    function listSubcategory(cid) {
        $('#subcategory').load("includes/select-subcategory.php", {'cid': cid});
    }

    /* <![CDATA[ */
    jQuery(function () {
        jQuery("#name").validate({
            expression: "if (VAL) return true; else return false;",
            message: "Name is Required field"
        });
        jQuery("#price").validate({
            expression: "if (!isNaN(VAL) && VAL) return true; else return false;",
            message: "Please enter a valid price."
        });
        jQuery("#weight").validate({
            expression: "if (!isNaN(VAL) && VAL) return true; else return false;",
            message: "Please enter a valid weight."
        });
        jQuery('.AdvancedForm').validated(function () {
            document.productInsert.submit();
        });
    });
    /* ]]> */
</script>
<?php
include("classes/category.class.php");

$month = array('mmm', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

//for breadcrumb
if (isset($_GET['p'])) {
    $parent_id = $_GET['p'];
} else {
    $parent_id = '0';
}
$cid = $parent_id;

$parent_id1 = $parent_id;
$catarr[] = $parent_id;
while ($parent_id1 != 0) {
    $parent_id1 = $menuObj->getParentId($parent_id1);
    $catarr[] = $parent_id1;
}

if (isset($_POST['btnDo']) && $_POST['btnDo'] == 'Add') {
    //print_r($data);
    $cid = $_GET['p'];
    $data['cid'] = $cid;

    foreach ($_POST as $key => $value) {
        if ($key != "btnDo" && $key != "y1" && $key != "m1" && $key != "d1")
            $data[$key] = $value;
    }

    $data['date_added'] = $_POST['y1'] . '-' . $_POST['m1'] . '-' . $_POST['d1'];
    $data['urlcode'] = $mydb->clean4urlcode(trim($_POST['name']));

    //print_r($data); exit();

    $pid = $mydb->insertQuery('tbl_product', $data);

    if ($pid > 0) {
        $data = '';
        $data['itemcode'] = date('y') . '-' . $pid;

        $mydb->updateQuery('tbl_product', $data, 'id=' . $pid);
        $message = "New Product Has been added.";
    }

    $url = ADMINURLPATH . "product_manage&p=" . $cid . "&code=1&message=" . $message;
    $mydb->redirect($url);
}

if (isset($_POST['btnDo']) && $_POST['btnDo'] == 'Update') {
    foreach ($_POST as $key => $value) {
        if ($key != "btnDo" && $key != "y1" && $key != "m1" && $key != "d1")
            $data[$key] = $value;
    }
    $data['date_added'] = $_POST['date_added'];
    $data['urlcode'] = $mydb->clean4urlcode(trim($_POST['name']));
    //print_r($data);
    $message = $mydb->updateQuery('tbl_product', $data, 'id=' . $pid);

    $url = ADMINURLPATH . "category_manage&p=" . $cid . "&code=1&message=" . $message;
    $mydb->redirect($url);
}
$rasProduct = $mydb->getArray('*', 'tbl_product', 'id=' . $pid);

if ($rasProduct['cid'] > 0) {
    $cid = $rasProduct['cid'];
    $scid = $rasProduct['scid'];
} else {
    $scid = $_GET['p'];
    $cid = $mydb->getValue('parent_id', 'tbl_category', 'id=' . $scid);
}
if (isset($rasProduct['date_added']) && !empty($rasProduct['date_added'])) {
    $aa = explode('-', $rasProduct['date_added']);
    $y1 = $aa['0'];
    $m1 = $aa['1'];
    $d1 = $aa['2'];
} elseif (isset($_POST['d1'])) {
    $y1 = $_POST['y1'];
    $m1 = $_POST['m1'];
    $d1 = $_POST['d1'];
} else {
    $y1 = date('Y');
    $m1 = date('m');
    $d1 = date('d');
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
        </table>
    </div>
    <?php
}
?>

<form name="productInsert" method="post" action="" enctype="multipart/form-data" id="mainform">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" id="id-form">


        <tr>
            <th>Date :</th>
            <td>
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>

                        <td><input name="date_added" type="text" class="tcal" placeholder="added date"
                                   value="<?php echo $rasProduct['date_added'] ?>"/></td>

                    </tr>
                </table>
            </td>
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
            <td><input name="name" id="name" type="text" value="<?php echo $rasProduct['name']; ?>" class="inp-form"/>
            </td>
        </tr>
        <tr>
            <th>Description :</th>
            <td><textarea name="description" id="description" cols="120" rows="7"
                          class="form-textarea"><?php echo $rasProduct['description']; ?></textarea></td>
        </tr>
        <tr>
            <th>Quantity :</th>
            <td><input name="quantity" id="quantity" type="text" value="<?php echo $rasProduct['quantity']; ?>"
                       class="inp-form"/></td>
        </tr>
        <tr>
            <th>Cost Price</th>
            <td><input name="costprice" id="costprice" type="text" value="<?php echo $rasProduct['costprice']; ?>"
                       class="inp-form"/></td>
        </tr>
        <tr>
            <th>MRP :</th>
            <td><input name="mrp" id="mrp" type="text" value="<?php echo $rasProduct['mrp']; ?>" class="inp-form"/></td>
        </tr>
        <tr>
            <td align="right">&nbsp;</td>
            <td style="padding-bottom:15px;"><input name="btnDo" type="submit" value="<?php echo $do; ?>"
                                                    class="button"/></td>
        </tr>
    </table>
</form>
