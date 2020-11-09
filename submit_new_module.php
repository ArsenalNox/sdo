<pre>
<?php
include_once "dtb/dtb.php";

//создать папку для теста
//создать папку для изображений (папка будет создана даже если она будет пустой)
$module_name = $_POST['Module_name'];
$dir = preg_replace('/\s+/', '_', $module_name);
$path = 'tests/'.$dir;

//информация для проверки изображений
$allowed_extensions = array('jpg','jpeg', 'png');
$error = '';

if(!is_dir($path)){
  //Создание папки теста и папки изображений
  mkdir("$path");
  mkdir("$path/images");
} else {
  // echo "Директория $path уже существует";
}

//Массив, который будет переведён в json
$data[] = array(
  'Module_name' => "".$_POST['Module_name']."",
  'module_subject' => "".$_POST['module_subject']."",
  'quest_quantity' => "".$_POST['quest_quantity']."",
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
    // echo " Обработка изображения к вопросу $i ";
    $imageName = $_FILES["question_image_$i"]['name'];
    $imageTmpName = $_FILES["question_image_$i"]['tmp_name'];
    $imageSize = $_FILES["question_image_$i"]['size'];
    $imageError = $_FILES["question_image_$i"]['error'];
    $imageType = $_FILES["question_image_$i"]['type'];
    $imageExtTmp = explode('.', $imageName);
    $imageExtAct = strtolower(end($imageExtTmp));
    // print_r($_FILES["question_image_$i"]);
    // TODO: Углоубленная проверка загружаемого изображения
    if($imageError === 0){
      $imagepath = "$path/images/image_q_$i.$imageExtAct";
      // echo "$imagepath";
      move_uploaded_file($imageTmpName, $imagepath);
    } else {
      $error .= "<p class='upload-error'> Случилась ошибка при загрузки изображения для вопроса номер $i текст ошибки:".$imageError."</p>";
    }
  }
  //Добавляем в массив со всей информаций теста массив вопроса
  $data[] = array(
    "QUESTION_NUM" => "$i",
    "VAR" => "1",
    "IMAGE" => $imagepath,
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
$qst = $path.'/'.$_POST['Module_name'].'.json';
$sbj = $_POST['module_subject'];
$sql = "INSERT INTO new_module (`Name`,`Class`,`Questions`,`subject`) VALUES (
  '$name',
  '$class',
  '$qst',
  '$sbj')";
$result = mysqli_query($conn, $sql);
$jsoned_data = json_encode($data,JSON_UNESCAPED_UNICODE);
$module_name = preg_replace('/\s+/', '_', $module_name);
$fp = fopen($path.'/'. $_POST['Module_name'] . '.json', 'w');
fwrite($fp, json_encode($data, JSON_UNESCAPED_UNICODE));
fclose($fp);
print_r($data);
header("Location: create_module.php?succes=true");
?>
</pre>
