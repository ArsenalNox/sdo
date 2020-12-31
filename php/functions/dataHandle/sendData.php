<?php
session_start();
include_once "../../../dtb/dtb.php";
if(isset($_SESSION['test_ids'])){
	//Проверить если есть массив неотправленных айди
	$postData = json_decode($_SESSION['test_ids']);
	foreach($postData as $id){
		$sql = "SELECT * FROM test_results WHERE id = '$id'";
		$result = mysqli_query($conn, $sql);
		if($result){

		}
		$cURLConnection = curl_init('http://localhost/dataAggr/index.php');
		curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $testData);
		curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

		$api_respone = curl_exec($cURLConnection);
		curl_close($cURLConnection);	
	}
	print_r($api_respone);
}
?>
