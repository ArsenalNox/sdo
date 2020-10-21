<?php
session_start();
include_once "../../dtb/dtb.php";
$numbers = array(1,2,3,4);
echo "
<div class='new-question-input'>
<textarea id='nq_" . $_SESSION['QUESTIONS_QUANTITY_CREATED'] . "' name='new_question_" . $_SESSION['QUESTIONS_QUANTITY_CREATED'] . "' rows='8' cols='80' style='resize:none' placeholder='Текст вопроса'></textarea>
<br>
<textarea name='correct_answer_". $_SESSION['QUESTIONS_QUANTITY_CREATED'] ."' rows='8' cols='80' placeholder='Правильный вариант ответа'></textarea>
<textarea name='incorrect_anwer_". $_SESSION['QUESTIONS_QUANTITY_CREATED'] ."' rows='8' cols='80' placeholder='Неправильный вариант ответа'></textarea>
<textarea name='incorrect_anwer_". $_SESSION['QUESTIONS_QUANTITY_CREATED'] ."' rows='8' cols='80' value='0' placeholder='Неправильный вариант ответа (Можно оставить пустым)'></textarea>
<textarea name='incorrect_anwer_". $_SESSION['QUESTIONS_QUANTITY_CREATED'] ."' rows='8' cols='80' value='0' placeholder='Неправильный вариант ответа (Можно оставить пустым)'></textarea>

</div>
";
$_SESSION['QUESTIONS_QUANTITY_CREATED']++;
?>
