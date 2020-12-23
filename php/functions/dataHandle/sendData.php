<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

include_once "../../../dtb/dtb.php";

$sql = "SELECT * FROM test_results WHERE sent = '0'";
$result = mysqli_query($conn, $sql);
$i = 0;
echo "data: $sql";

flush();
?>
