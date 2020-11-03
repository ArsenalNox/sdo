<?php

include_once "dtb/dtb.php";
$module_name = $_POST['Module_name'];
$data[] = array(
  'Module_name' => "".$_POST['Module_name']."",
  'module_subject' => "".$_POST['module_subject']."",
  'quest_quantity' => "".$_POST['quest_quantity']."");
for ($i=1; $i < $_POST['quest_quantity']+1; $i++) {
  $questions = array(
    $_POST["question_answer_a_$i"],
    $_POST["question_answer_b_$i"],
    $_POST["question_answer_c_$i"],
    $_POST["question_answer_d_$i"]);
  shuffle($questions);
  $data[] = array(
    "QUESTION_NUM" => "$i",
    "VAR" => "1",
    "IMAGE" => "",
    "QUESTION" => $_POST["question_text_$i"],
    "A" => $questions[0],
    "B" => $questions[1],
    "C" => $questions[2],
    "D" => $questions[3],
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
?>
</pre>
