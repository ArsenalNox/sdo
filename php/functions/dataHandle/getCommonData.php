<?php
include_once "../../../dtb/dtb.php";
function getStudentId($student, $link){

        //получаем айди студента и айди класса
        $studentName = explode(" ", $student);
        $firstName = $studentName[1];
        $lastName = $studentName[0];
        $studIdSql = "SELECT ID,GROUP_STUDENT_ID FROM student WHERE LAST_NAME='$lastName' and NAME='$firstName'";
        $studQuery = mysqli_query($link, $studIdSql);
        if($studQuery){
          $studIdRow = mysqli_fetch_assoc($studQuery);
        } else {
          $studIdRow = 'ERROR';
          return $studIdRow;
        }
        return $studIdRow;
}



$sql = 'SELECT * FROM test_results WHERE sent = 0';
$result = mysqli_query($conn, $sql);
if($result){
	$data['notSent'] = mysqli_num_rows($result);
	if(mysqli_num_rows($result)>0){
		while($row = mysqli_fetch_assoc($result)){
			$test['id'] = $row['id'];
			$test['date'] = $row['date'];
			$test['student'] = getStudentId($row['student'], $conn);
			$testData[] = $test;
		}
	}
	$data['testData'] = $testData;
} else {
	$data['errors'] = 'Произошла ошибка при запросе';
}

echo json_encode($data);
