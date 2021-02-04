<?php


include_once 'dtb/dtb.php';

$sql1 = "SELECT * FROM test_results WHERE module=''";
$result1 = mysqli_query($conn, $sql1);
if($result1){
	while($row = mysqli_fetch_assoc($result1)){
		$sql2 = "ALTER TABLE tr_".$row['id']." ADD qtype varchar(255)";
		$result2 = mysqli_query($conn, $sql2);
		for($i = 1; $i < 8; $i++){
			switch ($i){
			case 1:
				$sql3 = "UPDATE tr_".$row['id']." set qtype = 'Решение текстовых задач' WHERE id ='1' ";
				break;
			case 2:
				$sql3 = "UPDATE tr_".$row['id']." set qtype = 'Решение текстовых задач' WHERE id ='2' ";
				break;
			case 3:
				$sql3 = "UPDATE tr_".$row['id']." set qtype = 'Решение текстовых задач' WHERE id ='3' ";
				break;
			case 4:
				$sql3 = "UPDATE tr_".$row['id']." set qtype = 'Решение задач с диаграммы' WHERE id ='4' ";
				break;
			case 5:
				$sql3 = "UPDATE tr_".$row['id']." set qtype = 'Решение текстовых задач' WHERE id ='5' ";
				break;
			case 6:
				$sql3 = "UPDATE tr_".$row['id']." set qtype = 'Решение задач с таблиц' WHERE id ='6' ";
				break;
			case 7:
				$sql3 = "UPDATE tr_".$row['id']." set qtype = 'Решение задач с таблиц' WHERE id ='7' ";
				break;
			}
			$result3 = mysqli_query($conn, $sql3);
		}
	}
}
