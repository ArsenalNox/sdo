<?php
session_start();
include_once '../../../dtb/dtb.php';

function fillWithZeroes($stringToFill, $zeroes){
	while(strlen($stringToFill) < $zeroes){
		$stringToFill = '0'.$stringToFill;
	}
	return $stringToFill;
}

function getModuleSubjectFromTestId($testId, $link){
	$sql = "SELECT module FROM test_results WHERE id = '$testId'";
	$result = mysqli_query($link, $sql);
	if($result){
		$row = mysqli_fetch_assoc($result);
		$sql = "SELECT subject FROM new_module WHERE Name = '".$row['module']."' ";
		$result = mysqli_query($link, $sql);
		if($result){
			$row = mysqli_fetch_assoc($result);
			return $row['subject'];
		} else {
			return null;
		}
	} else {
		return null;
	}

}

function getModuleNameByTestId($testId, $link){
	$sql = "SELECT module FROM test_results WHERE id='$testId'";
	$result = mysqli_query($link, $sql);
	if($result){
		$row = mysqli_fetch_assoc($result);
		return $row['module'];
	} else { 
		return null; 
	} 
}

for($i=0;$i<count($_SESSION['test_ids']); $i++){
	$sql = "SELECT * FROM tr_".$_SESSION['test_ids'][$i]['id']."";
	$result = mysqli_query($conn, $sql);
	if($result){
		if(mysqli_num_rows($result)>0){
			$testInfoToSend['meta']['absId'] = '000001.';
			$testInfoToSend['meta']['absId'] .= fillWithZeroes($_SESSION['test_ids'][$i]['student']['GROUP_STUDENT_ID'], 6).".";
			$testInfoToSend['meta']['absId'] .= fillWithZeroes($_SESSION['test_ids'][$i]['student']['ID'], 6).".";
			$testInfoToSend['meta']['absId'] .= fillWithZeroes($_SESSION['test_ids'][$i]['id'], 6);
			$testInfoToSend['meta']['date'] = $_SESSION['test_ids'][$i]['date'];
			$testInfoToSend['meta']['module'] = getModuleNameByTestId($_SESSION['test_ids'][$i]['id'], $conn);
			$testInfoToSend['meta']['subject'] = getModuleSubjectFromTestId($_SESSION['test_ids'][$i]['id'], $conn);
			$qnum = 1;
			while($row = mysqli_fetch_assoc($result)){
				$testInfoToSend['test_content'][$qnum]['test_num'] = $row['id'];
				$testInfoToSend['test_content'][$qnum]['test_var'] = $row['Question_var']; 
				$testInfoToSend['test_content'][$qnum]['test_question'] = $row['Question_text'];	
				$testInfoToSend['test_content'][$qnum]['test_type'] = $row['qtype'];	
				$testInfoToSend['test_content'][$qnum]['correctness'] = $row['Correctness'];
				$testInfoToSend['test_content'][$qnum]['correct_answer'] = $row['Correct_answer'];
				$testInfoToSend['test_content'][$qnum]['given_answer'] = $row['Given_answer']; 
				$qnum++;
			}
		}
	} else {continue;}
	$InfoToSend[] = $testInfoToSend;
}
echo "<pre>";
print_r($InfoToSend);
echo "</pre>";
?>
