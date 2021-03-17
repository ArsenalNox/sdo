<!DOCTYPE html>
<?php
// TODO: Логирование ученика
// TODO: Обнуление статуса ученика когда он закрывает страницу
    error_reporting(E_ALL);
    include_once "dtb/dtb.php";
    session_start();
    $ip = $_SERVER['REMOTE_ADDR'];
    $_SESSION['IP'] = $ip;
    if(!isset($_COOKIE['UTSID'])){
      setcookie('UTSID', md5( date("Y-m-d H:i:s") ), time()+86400*30*2);
      header("Refresh:0");
      die();
    }
    $uqin = $_COOKIE['UTSID'];
    //получение статуса ученика
    echo "<p style='display:none;' id='ip'>$ip</p>";
    $sql = "SELECT * FROM connectons WHERE uiqname = '$uqin';";
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
        $uname = $_COOKIE['UTSID'];
        $sql = "INSERT INTO connectons (
           ip, uiqname, student_uid, status, group_nl, test_status, test_id)
           VALUES (
          '$ip', '$uname', '', '0', '', '', '') ;";
        $insert = mysqli_query($conn, $sql);
    }
    $newDate = date("Y-m-d H:i:s");
    $updateLastDateSql = "UPDATE connectons SET lastdate = '$newDate' WHERE uiqname = '$uqin'";
    $updateQuery = mysqli_query($conn, $updateLastDateSql);
?>
<html lang="ru">
<head>
    <link rel="stylesheet" href="css/style.css">
    <!-- <link rel="stylesheet" href="css/media.css"> -->
    <link rel="stylesheet" href="css/fonts.css">
    <meta charset="UTF-8">
    <meta name="viewport" width="device-width, initial-scale=1.0">
    <title>Панель обучающегося</title>
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
                            $sql = "SELECT * FROM group_student ORDER BY NAME DESC";
                            $result = mysqli_query($conn, $sql);
                            echo "<option>--Класс--</option>";
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
        <button class="help" onclick="PopUpShow()">Инструкия</button>
        <div class="b-popup" id="popup1">
            <div class="b-popup-content">
                <a href="javascript:PopUpHide()" class="close">X</a>
                <div class="studentPanel">
                    <h2>Панель обучающегося</h2>
                    <p>Цель использования: зайти за нужного обучающегося и пройти тест нужного модуля.</p>
                    <ul>
                        <li>
                            1.	Зайти на http://176.28.64.201:83/sdo 
                        </li>
                        <li>2.	Выбрать класс и ученика (и нажать на кнопку «войти») <br>
                            <img src="img/1.png" alt="">
                        </li>
                        <li>
                            3.	Выбрать нужный тест (тут показывается все доступные или пройденные тесты, ученик выбирает тот, который учитель скажет или доступный). <br>
                            <img src="img/2.png" alt="">
                        </li>
                        <li>
                            4.  Открывается выбранный тест. Что бы выбрать ответ нужно кликнуть на него, ответ выберется. Что бы пропустить вопрос надо кликнуть на кнопку после вопроса.
                            <img src="img/14.png" style="width: 500px;">
                        </li>
                        <li>
                            5.	Пройти тест и отправить результат (ответить на все задания и нажать на кнопку «завершить тест», после будет показаны задания и правильно он ответил или нет, а также процент правильных ответов).
                        </li>
                        <li>
                            6.	Нажать на кнопку «Вернутся на главную».
                        </li>
                    </ul>
                </div>
                <!-- <a href="javascript:PopUpHide()">X</a> -->
            </div>
        </div>
    </section>
    <script src="js/jquery-3.5.1.js" charset="utf-8"></script>
    <script>
    $(document).ready(function(){
        //Скрыть PopUp при загрузке страницы    
        PopUpHide();
    });
    //Функция отображения PopUp
    function PopUpShow(){
        $("#popup1").show();
    }
    //Функция скрытия PopUp
    function PopUpHide(){
        $("#popup1").hide();
    }
    </script>
</body>
</html>
