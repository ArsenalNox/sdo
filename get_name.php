<?php
    include_once "dtb/dtb.php";
    $sql = "SELECT * FROM student WHERE `GROUP_STUDENT_ID`='".$_POST["group_student"]."' ";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        echo "<option value=''>--Выберите ФИО--</option>";
        while($row = mysqli_fetch_assoc($result)){
            $first_name = $row['NAME'];
            $last_name = $row['LAST_NAME'];
            $middle_name = $row['MIDDLE_NAME'];
            $id = $row['ID'];
            echo "<option value=$id'> $last_name $first_name $middle_name </option>";
        }
    }
?>