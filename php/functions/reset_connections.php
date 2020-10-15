<?php
//Сброс соединений
include_once "../../dtb/dtb.php";
$sql = "DELETE FROM connectons;";
$result = mysqli_query($conn, $sql);

?>
