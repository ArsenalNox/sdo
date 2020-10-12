<?php
  include_once "dtb/dtb.php";
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <link rel="stylesheet" href="css/main.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель управления</title>
</head>
<body>
<script src="js/panel.js"></script>
    <?php
        $sql = "SELECT * FROM connectons;";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0){
            while($row = $result->fetch_assoc()){
                $ip = $row['ip'];
                $status = $row['status'];
                if( $row['student_uid'] == '' ){
                    $uid = '';
                } else {
                    $uid = $row['student_uid'];
                }
                $id = $row['id'];
                switch($status){
                    case 0:
                        echo "
                        <p>
                        <button onclick='ConfirmStudent($id)'> Подтвердить </button>
                        $ip : $uid
                        </p>
                        ";
                        break;
                    case 1:
                        echo "
                        <p>
                        <button class='confirmed-button' onclick='DeconfirmStudent($id)'> Подтвердить </button>
                        $ip : $uid
                        </p>
                        ";
                        break;
                }
            }
        } else {
            echo "Пока никого нету";
        }
    ?>

<section>
  <div class="">
    <p>Тестовое изменение</p>
  </div>
</section>

</body>
</html>
