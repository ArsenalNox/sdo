<?php
include_once "../../../dtb/dtb.php";

$sql = 'SELECT * FROM test_results WHERE sent = 0';
$result = mysqli_query($conn, $sql);
if($result){
	$data['notSent'] = mysqli_num_rows($result);
} else {
	$data['errors'] = 'Произошла ошибка при запросе';
}

echo json_encode($data);
