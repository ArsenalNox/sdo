<!DOCTYPE html>
<?php
    include_once "dtb/dtb.php";
    session_start();
    $ip = $_SERVER['REMOTE_ADDR'];
    $_SESSION['IP'] = $ip;
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
        $sql = "INSERT INTO connectons (ip, student_uid, status, group_nl, test_status, test_id) VALUES ('$ip', '', '0', '', '', '') ;";
        $insert = mysqli_query($conn, $sql);
    }
?>
<html lang="ru">
<head>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/student.css">
    <!-- <link rel="stylesheet" href="css/media.css"> -->
    <link rel="stylesheet" href="css/fonts.css">
    <meta charset="UTF-8">
    <meta name="viewport" width="device-width, initial-scale=1.0">
    <title>Панель студента</title>
</head>
<body>
    <script src="js/jquery-3.5.1.js"></script>
    <script src="js/student.js"></script>
    <script src="js/student-interface.js" charset="utf-8"></script>
    <section class="student-wrapper">
      <input type="hidden" name="student_test_status" value="test_not_selected" id='student_test_status'>
    <fieldset class="fieldset">

        <div class="">
            <div class="selection" id='sg1'><h1 class="group">ВЫБЕРИТЕ СЕБЯ:</h1>
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
                        <button type="submit" class="buttonindex" onclick='SendStudentInfo()' id='sl' style='display: none;'> Войти </button>
            </div>
            <div class="student-info">
                <?php  if($status == true){
                $_SESSION['IP'] = $ip;
                $_SESSION['UID'] = $uid;
                $_SESSION['GROUP_UID'] = $group;
                echo "
                  <div class='info'> <p class='infotext'>Вы вошли как: $uid, <span id='student_group'>$group</span></p>
                  <button onclick='Deauthorization()' class='auth-button' id='nauth'> Новая авторизация </button>
                  <input type='hidden' name='student_uid' value='$uid' id='suid'>
                  <script>
                      document.getElementById('sg1').style.display = 'none';
                      LoadTests();
                      var auto_update_timer_demote = setInterval(update_status_demote, 3000);
                      var test_update = setInterval(set_test_status, 3000);
                  </script>
                  </div>
                  ";
                }
                if(isset($_GET['status'])){
                    if(isset($_GET['test'])){
                      echo "
                      <script type='text/javascript'>
                        var status = true
                        var test = '".$_GET['test']."'
                        sendtestinfo()
                      </script>
                      ";
                  }
                } else {
                  echo "
                  <script type='text/javascript'>
                    var test = false;
                  </script>
                  ";
                }
                ?>
            </div>
        </div>
        <div class="main-testfield" id='mtf'>
        </div>
        <div class="test" id='test'>
        </div>
        </fieldset>
    </section>
    <script src="js/jquery-3.5.1.js" charset="utf-8"></script>

</body>
</html>
