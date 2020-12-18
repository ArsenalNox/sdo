<?php
include_once "../../dtb/dtb.php";
//Выбираем классы и выводим в список классы
$groupQuery = "SELECT * FROM group_student ORDER BY NAME DESC;";
$result = mysqli_query($conn, $groupQuery);
echo "<select id='group' name='group'> <option>--Класс--</option>";
if(mysqli_num_rows($result) > 0){
  while ($row = mysqli_fetch_assoc($result)) {
    $group = $row['NAME'];
    // $clsnum = preg_replace("/[^0-9]/","", $group);
    echo "<option value='$group'> $group </option>";
  }
} else {
  //Если пусто
  echo "Занесите в бд классы";
}
echo "</select>";
?>
