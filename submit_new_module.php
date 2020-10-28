<?php

// TODO: Новые формы для вопросов (по кол-ву ответов, по типу ответов и т.д.)
// TODO: Добавление картинок в вопрос

include_once "dtb/dtb.php";
$module_name = $_POST['Module_name'];
$data[] = array(
  'Module_name' => "".$_POST['Module_name']."",
  'module_subject' => "".$_POST['module_subject']."",
  'quest_quantity' => "".$_POST['quest_quantity']."");
for ($i=1; $i < $_POST['quest_quantity']+1; $i++) {
  $data[] = array(
    "QUESTION_NUM" => "$i",
    "VAR" => "1",
    "IMAGE" => "",
    "QUESTION" => $_POST["question_text_$i"],
    "A" => $_POST["question_answer_a_$i"],
    "B" => $_POST["question_answer_b_$i"],
    "C" => $_POST["question_answer_c_$i"],
    "D" => $_POST["question_answer_d_$i"],
    "CORRECT" => $_POST["question_answer_a_$i"],
    "NUM_ANSW" => '4'
  );
}
$class = $_POST['class'];
$name = $_POST['Module_name'];
$qst = 'json/Working_with_word_problems/'.$_POST['Module_name'].'.json';
$sbj = $_POST['module_subject'];
$sql = "INSERT INTO new_module (`Name`,`Class`,`Questions`,`subject`) VALUES ('$name', '$class', '$qst', '$sbj')";
$result = mysqli_query($conn, $sql);
$jsoned_data = json_encode($data,JSON_UNESCAPED_UNICODE);
$fp = fopen('json/Working_with_word_problems/'. $_POST['Module_name'] . '.json', 'w');
fwrite($fp, json_encode($data, JSON_UNESCAPED_UNICODE));
fclose($fp);
header("Location: panel.php");
die();
?>
</pre>
