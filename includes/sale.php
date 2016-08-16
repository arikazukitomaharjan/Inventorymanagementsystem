<!-- Validation -->

<link rel="stylesheet" href="validationEngine/validationEngine.jquery.css" type="text/css"/>
<script src="validationEngine/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8">
</script>
<script src="validationEngine/jquery.validationEngine.js" type="text/javascript" charset="utf-8">
</script>
<script type="text/javascript">
    $(document).ready(function () {
        // binds form submission and fields to the validation engine
        $('#productSale').validationEngine();
    });

    /**
     *
     * @param {jqObject} the field where the validation applies
     * @param {Array[String]} validation rules for this field
     * @param {int} rule index
     * @param {Map} form options
     * @return an error string if validation failed
     */
</script>


<?php
//print_r($_POST);
//print_r($_SESSION);
$message = '';
if (isset($_POST['btnDo'])) {
//    print_r($_POST['quantity']);
    if ($_POST['quantity'] <= 0) {
        $message .= 'Invalid Quantity';
    }
    if ($_POST['saleprice'] <= 0) {
        $message .= '<br>Amount Paid is mandatory';
    }

    if (empty($message)) {

        $id = $_POST['pid'];


        $rasPro = $mydb->getArray('id,quantity,sold_quantity', 'tbl_product', 'id="' . $id . '"');
        $av_qty = $rasPro['quantity'];
        $sold_quantity = $rasPro['sold_quantity'];
        $sale_quantity = $_POST['quantity'];






        if ($av_qty >= $sale_quantity) {
            $data = '';
            $data['quantity'] = $av_qty - $sale_quantity;
           $data['sold_quantity']=$sold_quantity+$sale_quantity;

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

           // $url = ADMINURLPATH . "sale&code=1&message=The selected product has been sold successfully.";
            $navigate=ADMINURLPATH ."category_manage&code=1&p=0&message=The selected product has been sold successfully.";
            $mydb->redirect($navigate);
        }
    }
}
//print_r($data);
if ((isset($message) && !empty($message)) || (isset($_GET['message']) && !empty($_GET['message']))) {
    if (isset($_GET['code']) && $_GET['code'] == 1) $ccode = 'green';
    else  $ccode = 'red';

    if (isset($_GET['message']) && !empty($_GET['message']))
        $message = $_GET['message'];
    ?>

    <div id="message-<?php echo $ccode; ?>" style="padding-top:10px;">
        <table border="0" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td class="<?php echo $ccode; ?>-left"><?php echo $message; ?></td>
                <td class="<?php echo $ccode; ?>-right"><a class="close-<?php echo $ccode; ?>"><img
                <td class="<?php echo $ccode; ?>-right"><a class="close-<?php echo $ccode; ?>"><img
                            src="images/table/icon_close_<?php echo $ccode; ?>.gif" alt=""/></a></td>
            </tr>
        </table>
    </div>
    <?php
}
?>


