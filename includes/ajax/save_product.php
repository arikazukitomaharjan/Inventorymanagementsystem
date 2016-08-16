<?php
/**
 * Created by PhpStorm.
 * User: sabin
 * Date: 7/4/16
 * Time: 3:30 PM
 */
include("../../classes/call.php");

$data['date_added'] = $_POST['date_added'];
$data['name'] = $_POST['name'];
$data['description'] = $_POST['description'];
$data['quantity'] = $_POST['quantity'];
$data['costprice'] = $_POST['costprice'];
$data['mrp'] = $_POST['mrp'];
$data['cid'] = $_POST['cid'];

$pid = $mydb->insertQuery('tbl_product', $data);

$message = "Successully added a product";

echo json_encode(['success' => true, 'msg' => 'successfull']);