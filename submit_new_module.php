<pre>
<?php
include_once "dtb/dtb.php";
include_once "php/functions/checkAuth.php";

print_r($_POST);
print_r($_FILES);

//создать папку для теста
//создать папку для изображений (папка будет создана даже если в модуле не будет ни одного изображения)
$module_name = $_POST['Module_name'];
$dir = preg_replace('/\s+/', '_', $module_name);
$path = 'tests/'.$dir;

//информация для проверки изображений
$allowed_extensions = array('jpg','jpeg', 'png', 'tiff');
$error = '';
if(!is_dir($path)){
  //Создание папки теста и папки изображений
  mkdir("$path", 0777);
  mkdir("$path/images", 0777);
}

//Массив, который будет переведён в json
//Добавляем в начало мета информацию
$data[] = array(
  'Module_name' => "".$_POST['Module_name']."",
  'module_subject' => "".$_POST['module_subject']."",
  'quest_quantity_actual' => "".$_POST['quest_quantity_actual']."",
  'class' => "".$_POST['class']."");

//Проходим по всем вопросам
for ($i=1; $i < $_POST['quest_quantity']+1; $i++) {
  //Перемешивание ответов
  $questions = array(
    $_POST["question_answer_a_$i"],
    $_POST["question_answer_b_$i"],
    $_POST["question_answer_c_$i"],
    $_POST["question_answer_d_$i"]);
  shuffle($questions);

  //проверка наличия у вопроса изображения, если нет - тэг останется пустым
  $imagepath = '';
  if(isset($_FILES["question_image_$i"])){
    //Загрузка изображения
    $imageName = $_FILES["question_image_$i"]['name'];
    $imageTmpName = $_FILES["question_image_$i"]['tmp_name'];
    $imageSize = $_FILES["question_image_$i"]['size'];
    $imageError = $_FILES["question_image_$i"]['error'];
    $imageType = $_FILES["question_image_$i"]['type'];
    $imageExtTmp = explode('.', $imageName);
    $imageExtAct = strtolower(end($imageExtTmp));
    if($imageError === 0){
      $imagepath = "$path/images/image_q_$i.$imageExtAct";
      move_uploaded_file($imageTmpName, $imagepath);
    } else {
      $error .= "<p class='upload-error'> Случилась ошибка при загрузки изображения для вопроса номер $i текст ошибки:".$imageError."</p>";
    }
  }else{
    echo "у задания $i нет картинки";
  }
  if(isset($_POST["question_type_$i"])){$qtype = $_POST["question_type_$i"];}else{ $qtype = '';}
  if(isset($_POST["question_subtype_$i"])){$qsubtype = $_POST["question_subtype_$i"];}else{ $qsubtype = '';}

  //Добавляем в массив задание
  $data[] = array(
    "QUESTION_NUM" => $_POST["question_a_num_$i"],
    "VAR" => $_POST["question_var_$i"],
    "IMAGE" => $imagepath,
    "TYPE" => 'choose-answer',
    "QUESTION_TYPE" => "$qtype",
    "QUESTION_SUBTYPE" => "$qsubtype",
    "QUESTION_COMMENTARY" => "",
    "QUESTION" => $_POST["question_text_$i"],
    "A" => $questions[0],
    "B" => $questions[1],
    "C" => $questions[2],
    "D" => $questions[3],
    "CORRECT" => $_POST["question_answer_a_$i"],
    "NUM_ANSW" => '4'
  );
}
//Вставляем в таблицу информацию о модуле
$class = $_POST['class'];
$name = $_POST['Module_name'];
$qst = $path.'/'.$_POST['Module_name'].'.json';

//Записываем тест в бд
$sbj = $_POST['module_subject'];
$sql = "INSERT INTO new_module (`Name`,`Class`,`Questions`,`subject`) VALUES (
  '$name',
  '$class',
  '$qst',
  '$sbj')";
$result = mysqli_query($conn, $sql);

//Записываем модуль в JSON
$jsoned_data = json_encode($data,JSON_UNESCAPED_UNICODE);
$module_name = preg_replace('/\s+/', '_', $module_name);
$fp = fopen($path.'/'. $_POST['Module_name'] . '.json', 'w');
fwrite($fp, json_encode($data, JSON_UNESCAPED_UNICODE));
fclose($fp);
header("Location: panel.php?succes=true");
?>
</pre>
