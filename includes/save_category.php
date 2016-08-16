<?php
/**
 * Created by PhpStorm.
 * User: sabin
 * Date: 7/4/16
 * Time: 3:30 PM
 */
include("../classes/call.php");


$data['name'] = $_POST['name'];
$data['description'] = $_POST['description'];


$pid = $mydb->insertQuery('tbl_category', $data);

$message = "Successully added a category. please add a product below";

echo json_encode(['success' => true, 'msg' => $message,'data'=>$pid]);