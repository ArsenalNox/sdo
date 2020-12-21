<?php
//Возвращает конкретный вопрос из таблицы 

include_once "../../dtb/dtb.php";
include_once "checkAuth.php";

if(isset($_POST['resultId']) && isset($_POST['questionNumber'])){
	$sql = "SELECT * FROM tr_".$_POST['resultId']." WHERE id = '".$_POST['questionNumber']."'";
	$result = mysqli_query($conn, $sql);
	if($result){
		if(mysqli_num_rows($result)>0){
			$row = mysqli_fetch_assoc($result);
			if( ($row['qtype'] == 'empty') || ( $row['qtype'] == '') ){
				$qtype = 'Тип вопроса не определён';
			} else {
				$qtype = $row['qtype'];
			}
	
			if($row['Correctness'] == 1){
				$answer = "<p style='color: #00FF00'> Ответ правильный </p>";
			} else {
				$answer = "<p style='color: #FF0000'> Ответ неправильный </p>";
			}
			if(isset($row['Image'])){
				if($row['Image']!==''){
					$image = "<img src='".$row['Image']."'>";
				} else {$image = '';}
			} else {$image = '';}
			echo"
				<div class='question-popup'> 
					<div id='colse-popup-button' style='float:right; border-bottom: 1px solid black; cursor: context-menu;'> закрыть </div> 
					<p> Вопрос №".$row['id']." Вариант:".$row['Question_var']."</p>	
					<p> Тип вопроса: $qtype </p>
					$image	
					<p> Текст вопроса:'".$row['Question_text']."' </p>
					<p> Правильный ответ: '".$row['Correct_answer']."'</p>
					<p> Ответ обучаещегося: '".$row['Given_answer']."'</p>
					$answer
				</div>			
			";
		} else {
			echo "<p> Ошибка: Запрос не дал результата. </p>";
		}
	} else {
		echo "<p> Ошибка: Запрос не удался. </p>";
	}
}

?>
