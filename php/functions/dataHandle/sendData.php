<?php
if(isset($_POST['test_ids'])){
	$testIds = $_POST['test_ids'];
	$postData = json_decode($testIds);

	$cURLConnection = curl_init('http://localhost/dataAggr/index.php');
	curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $postData);
	curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

	$api_respone = curl_exec($cURLConnection);
	curl_close($cURLConnection);
	echo $api_respone;
}
?>
