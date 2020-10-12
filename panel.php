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
  <section class='student-ip-panel'>
    <?php
        if(isset($_COOKIE['STS'])){
          $teachid = $_COOKIE['STS'];
          $checkteach = "SELECT id FROM teach WHERE uid = '$teachid' ;";
          $check = mysqli_query($conn, $checkteach);
          if(mysqli_num_rows($check) == 0){
            header("Location: panel-login.php");
            die();
          }
        } else {
          header("Location: panel-login.php");
          die();
        }
        echo $_COOKIE['STS'];
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
  </section>

<section class="module-wrapper">
  <div class="module-selector">
    <p>Тест</p>
  </div>
</section>

</body>
</html>
