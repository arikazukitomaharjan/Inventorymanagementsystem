<?php
/**
 * Created by PhpStorm.
 * User: sabin
 * Date: 7/4/16
 * Time: 3:30 PM
 */
include("../classes/call.php");

$data['date_added'] = $_POST['date_added'];
$id= $_POST['id'];
$data['name'] = $_POST['name'];
$data['description'] = $_POST['description'];
$data['quantity'] = $_POST['quantity'];
$data['costprice'] = $_POST['costprice'];
$data['mrp'] = $_POST['mrp'];
$data['cid'] = $_POST['cid'];

$mydb->updateQuery('tbl_product', $data, 'id=' . $id);

$message = "Successully added a product. please add a product below";

echo json_encode(['success' => true, 'msg' => $message,'data'=>$data]);