<?php
include_once 'dtb/dtb.php';
$id = $_POST['id'];
$action = $_POST['action'];

switch($action){
    case 'confirm':
        $sql = "UPDATE connectons SET status = 1 WHERE id = '$id'; ";
        $result = mysqli_query($conn, $sql);
    break;
    case 'deconfirm':
        $sql = "UPDATE connectons SET status = 0 WHERE id = '$id'; ";
        $result = mysqli_query($conn, $sql);
    break;


}