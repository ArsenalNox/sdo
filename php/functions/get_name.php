<?php
    include_once "../../dtb/dtb.php";
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $group = $_POST['group'];
      $sql = "SELECT * FROM student WHERE GROUP_STUDENT_ID ='$group'";
      $result = mysqli_query($conn, $sql);
      if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
          $firsName = $row['NAME'];
          $lastName = $row['LAST_NAME'];
          $middleName = $row['MIDDLE_NAME'];
          echo "
          <option value='$lastName $firsName $middleName'> $lastName $firsName $middleName </option>
          ";
        }
      }
    }
?>
