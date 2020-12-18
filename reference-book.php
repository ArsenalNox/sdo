<?php

session_start();
$referLessons = array('Математика','математика','физика','Физика','Химия','химия');
if(isset($_POST['test_request'])){
	if(isset($_SESSION['TEST_SUBJECT'])){
		if(in_array($_SESSION['TEST_SUBJECT'], $referLessons)){
			echo "includes";
			die();
		}	
	}
}
?>

<html lang="ru">
<head>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/student.css">
    <!-- <link rel="stylesheet" href="css/media.css"> -->
    <link rel="stylesheet" href="css/fonts.css">
    <meta charset="UTF-8">
    <meta name="viewport" width="device-width, initial-scale=1.0">
    <title> Справочный матерал </title>
</head>

<?php

function checkReferenceMaterial($checkSubject){
	//Проверяет наличие справочного материала у предмета, возвращает true если есть
	return true;
}

function loadReferenceMaterial($targetSubject){
	//Загружает из дерктории справочный материал	
}


if(isset($_SESSION['TEST_SUBJECT'])){

	$subject = strtolower($_SESSION['TEST_SUBJECT']);
//	$subject = 'Физика';
	switch($subject){
		case 'Математика':
			echo "
				<div>
					<p> 123 </p>
				</div>
			";
			break;
		case 'Физика':
			echo "
				<p style='background-color:wheat' onclick='showReferenceMaterial()'> Справочный материал по предмету $subject</p>
				<div class='ref-wrap' style='display: grid; text-align: center'>
					<img src='https://avatars.mds.yandex.net/get-tutor/1666524/9e0feb687eace1108315ab86b824fe10/orig'> <br>
					<img src='https://avatars.mds.yandex.net/get-tutor/1881309/70d25d8e49ab008706bb796502458fba/orig'> <br>
					<img src='https://avatars.mds.yandex.net/get-tutor/1881309/65340491a3c8776911fa1f53a2798c2b/orig'> <br>
					<img src='https://avatars.mds.yandex.net/get-tutor/1548979/323003bde1240b67aabed12e96a0916b/orig'> <br>
					<img src='https://avatars.mds.yandex.net/get-tutor/1666524/d6385fa2879621c9e2f605c8e4a0229b/orig'> <br>
					<img src='https://avatars.mds.yandex.net/get-tutor/1666524/c6adf18848495044d92dea226f5332e5/orig'> <br>
					<img src='https://avatars.mds.yandex.net/get-tutor/1677215/f3062a7c1c2bbc593e69130f2cea154b/orig'> <br>
				</div>
			";			
			break;
		case 'Химия':
			echo "
				<div class='ref-wrap' style='display: grid; text-align: center;'>
					<imt src='https://koliot.ru/wp-content/uploads/2020/01/Periodicheskaya-tablitsa-Mendeleeva.png'>		
				</div>	
			";	
			break;
	}
}else{
	header("Location: index.php");
}	
?>
