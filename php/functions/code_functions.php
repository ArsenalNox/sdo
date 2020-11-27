<?php
include_once "../../dtb/dtb.php";

function createDataset($data, $conection){
  $dataset = '';
  $sql = "SELECT DISTINCT $data FROM test_results";
  $result = mysqli_query($conection, $sql);
  $dataset = "<datalist id='$data-dataset'>";
  if($result){
    if(mysqli_num_rows($result) > 0){
          while ($row = mysqli_fetch_array($result)) {
            $student = $row["$data"];
            $dataset .=  "<option value='$student'> </option>";
          }
          $dataset .= "</datalist>";
          echo $dataset;
    }
  }
}


function echoQuestionImportError(){
    echo "<p> Вопрос не удалось ипортировать, недосаточно вариантов ответа </p>";
}

?>
