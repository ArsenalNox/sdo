<?php
    include_once "dtb/dtb.php";
    session_start();
    $ip = $_SERVER['REMOTE_ADDR'];
    //получение статуса ученика
    echo "<p style='display:none;' id='ip'>$ip</p>";
    $sql = "SELECT * FROM connectons WHERE ip = '$ip';";
    $result = mysqli_query($conn, $sql);
    $status = 0;
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $status = $row['status'];
        $group = $row['group_nl'];
        $uid = $row['student_uid'];
    } else {
        if(!isset($uid)){
            $uid = '';
        }
        $sql = "INSERT INTO connectons (ip, student_uid, status, group_nl) VALUES ('$ip', '', '0', '') ;";
        $insert = mysqli_query($conn, $sql);
    }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/student.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>СДО</title>
</head>
<body>
    <script src="js/jquery-3.5.1.js"></script>
    <script src="js/student.js"></script>
    <section class="student-wrapper">
      <input type="hidden" name="student_test_status" value="test_not_selected" id='student_test_status'>
    <fieldset class="fieldset">
        <div class="">
            <div class="selection" id='sg1'><h1 class="group">ВЫБЕРИТЕ КЛАСС:</h1>
                    <select name="get_group" id="student_group_selector" class="get_group" onchange="GetGroupNames()">
                        <?php
                            $sql = "SELECT * FROM group_student";
                            $result = mysqli_query($conn, $sql);
                            echo "<option>--</option>";
                            if(mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_assoc($result)){
                                    $name = $row['NAME'];
                                    $id = $row['ID'];
                                    echo "<option value=$id>$name</option>";
                                }
                            }
                        ?>
                    </select>
                    <select name="get_name" id="group_names" class="get_name" style="margin-bottom: 20px;">
                        <option value=''> --Выберите Класс-- </option>";
                    </select>
                        <button type="submit" class="buttonindex" onclick='SendStudentInfo()'>Отправить</button>
            </div>

            <div class="student-info">
                <?php  if($status == true){
                $_SESSION['IP'] = $ip;
                $_SESSION['UID'] = $uid;
                $_SESSION['GROUP_UID'] = $group;
                echo "
                  <h4> Вы подтверждены как: $uid, <span id='student_group'>$group</span>
                  <input type='hidden' name='student_uid' value='$uid' id='suid'>
                  <script>
                      document.getElementById('sg1').style.display = 'none';
                      LoadTests();
                      var test_update = setInterval(set_test_status, 3000);
                  </script>
                  </h4>
                  ";
                }
                else {
                  echo "<h4>Ожидание подтверждения как $uid
                  </h4>
                  <script type='text/javascript'>
                    var auto_update_timer = setInterval(update_status, 3000);
                  </script>
                  ";
                } ?>
            </div>
        </div>
        <br>
        <div class="main-testfield" id='mtf'>
        </div>
        <div class="test" id='test'>
        </div>
        </fieldset>
    </section>
</body>
</html>
