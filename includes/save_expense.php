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
$data['cost'] = $_POST['cost'];
$data['date'] = $_POST['date'];
$data['userid'] =(int)$_SESSION[ADMINUSER];


$pid = $mydb->insertQuery('tbl_expense', $data);

$message = "Successully added a expense. please add a expense below";

echo json_encode(['success' => true, 'msg' => $message,'data'=>$pid]);