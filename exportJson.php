<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php

      include_once 'dtb/dtb.php';
      function export($id,$link){

        $sql = "SELECT * FROM test_results WHERE id = '$id' ";
        $result = mysqli_query($link, $sql);
        if($result){
          $sql2 = "SELECT * FROM tr_$id";
          $result2 = mysqli_query($link, $sql2);
          if($result2){
            $row = mysqli_fetch_assoc($result);
            $jsonArrayMeta['test_id'] = $row['id'];
            $jsonArrayMeta['student'] = $row['student'];
            $jsonArrayMeta['class'] = $row['class'];
            $jsonArrayMeta['date'] = $row['date'];
            $jsonArrayMeta['module'] = $row['module'];
            while($row = mysqli_fetch_assoc($result2)){
              $jsonTestContents['Question_num'] = $row['id'];
              $jsonTestContents['Question_var'] = $row['Question_var'];
              $jsonTestContents['Question_text'] = $row['Question_text'];
            	$jsonTestContents['Correct_answer'] = $row['Correct_answer'];
              $jsonTestContents['Given_answer'] = $row['Correct_answer'];
              $jsonTestContents['Correctness'] = $row['Correctness'];
              $jsonTestContents['qtype'] = $row['qtype'];
              $jsonArrayHolder["question_".$row['id']] = $jsonTestContents;
            }
            $jsonArray['meta'] = $jsonArrayMeta;
            $jsonArray['test_content'] = $jsonArrayHolder;
            $actj['test'] = $jsonArray;
            return $actj;
            $actj = json_encode($actj);
          }
        }

        // $file = fopen("exported/test_$id.json","w");
        // fwrite($file, $actj);
      }
      $sql = "SELECT id FROM test_results";
      $result = mysqli_query($conn, $sql);
      if($result){
        while($row = mysqli_fetch_assoc($result)){
          echo"<p> Exporting test ".$row['id']."</p> <br>";
          $toExport[] = export($row['id'],$conn);
        }
      }
      $toExport = json_encode($toExport);
      $file2 = fopen("tests.json","w");
      fwrite($file2, $toExport);

    ?>

  </body>
</html>
