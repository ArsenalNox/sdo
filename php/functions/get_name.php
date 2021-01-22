<?php
    include_once "../../dtb/dtb.php";
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $group = $_POST['group'];

      $currentStudents = array('');
      $checkSql = "SELECT DISTINCT student_uid FROM connectons";
      $check = mysqli_query($conn, $checkSql);
      if($check){
        if(mysqli_num_rows($check)>0){
          while ($row = mysqli_fetch_assoc($check)) {
            array_push($currentStudents, $row['student_uid']);
          }
        }
        print_r($currentStudents);
      }
      $sql = "SELECT * FROM student WHERE GROUP_STUDENT_ID ='$group' ORDER BY LAST_NAME ASC, NAME";
      $result = mysqli_query($conn, $sql);
      if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
          $firsName = $row['NAME'];
          $lastName = $row['LAST_NAME'];
          $middleName = $row['MIDDLE_NAME'];
          $full = "$lastName $firsName $middleName";
          if(!(in_array($full, $currentStudents))){
            echo "
            <option value='$lastName $firsName $middleName'> $lastName $firsName $middleName </option>
            ";
          }
        }
      }
    }
?>
