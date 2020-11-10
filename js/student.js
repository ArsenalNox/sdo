//Переменные состояния
var t_not = 'test_not_selected';
var t_ong = 'test_started';
var t_cmp = 'completed';

function GetGroupNames() {
  //Получает все имена класса
  var xhttp = new XMLHttpRequest();
  var student_group = document.getElementById('student_group_selector').value;
  console.log('Requesting names for ', student_group);
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      console.log('Done!', this.responseText);
      document.getElementById('group_names').innerHTML = this.responseText;
    }
  };
  xhttp.open("POST", "php/functions/get_name.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("group=" + student_group);
}

function LoadTests() {
  //Загружает тесты
  var xhttp = new XMLHttpRequest();
  var student_group = document.getElementById('student_group').textContent;
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      console.log(student_group);
      document.getElementById('mtf').innerHTML = this.responseText;
    }
  };
  xhttp.open("POST", "php/functions/load_avaliable_tests.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("group=" + student_group);
}

function SendStudentInfo() {
  //Отправка выбранной инофрмации об ученике в таблицу
  var xhttp = new XMLHttpRequest();
  var new_name = document.getElementById('group_names').value;
  var ip = document.getElementById('ip').textContent;
  var student_group = document.getElementById('student_group_selector').value;
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      location.reload();
    }
  };
  xhttp.open("POST", "php/functions/insert_new_student_name.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("new_name=" + new_name + "&ip=" + ip + "&nl=" + student_group);
}

function startTest(id) {
  //Начинает тест по его id
  document.getElementById('student_test_status').value = t_ong
  var test_id = id;
  document.getElementById('mtf').remove();
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById('test').innerHTML = this.responseText;
      document.title = document.getElementById('ntl').value;
    }
  };
  xhttp.open("POST", "php/functions/student_start_test.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("test_id=" + test_id);
}

function getStatus() {
  // QUESTION: Функция почти не отлчиается от предидущей. Скорее всего будет удалена
  var test_id = id;
  document.getElementById('mtf').remove();
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById('test').innerHTML = this.responseText;
    }
  };
  xhttp.open("POST", "php/functions/student_start_test.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("test_id=" + test_id);
}

function set_test_status() {
  //Обновляет состояние ученика (Не выбрал, начал, завершил тест)
  var xhttp = new XMLHttpRequest();
  var id = document.getElementById('suid').value;
  var student_test_status = document.getElementById('student_test_status').value;
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      console.log(id, student_test_status, this.responseText);
    }
  };
  xhttp.open("POST", "php/functions/update_student_status.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("status=" + student_test_status + "&id=" + id);
}

function update_status() {
  //Проверка статуса из неподтверждённого состояния
  console.log('Проверка статуса');
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      console.log(this.responseText);
      if(this.responseText == "OK"){
        location.reload();
      }
    }
  };
  xhttp.open("POST", "php/functions/autoupdatestudent.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("stat");
}

function update_status_demote(){
    //Проверяет статус студента когда студент подтверждён. Если статус NO обновить страницу и ждать подтверждения
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        if( (this.responseText == "NO") || (this.responseText == 'not found') ){
          location.reload();
        }
      }
    };
    xhttp.open("POST", "php/functions/autoupdatestudent.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("stat");
}

function sendtestinfo(){
  //Отправляет адрес таблицы с выполненым тестом в таблицу соединений
  var xhttp = new XMLHttpRequest();
  var id = document.getElementById('suid').value
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        console.log(test, this.responseText);
    }
  };
  xhttp.open("POST", "php/functions/set_student_completed_test.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("status="+test+"&id="+id);
}

function Deauthorization(){
  //Сбрасывает статус студента, по сути релогин
  var xhttp = new XMLHttpRequest();
  var studid = document.getElementById('suid').value;
  console.log(studid);
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      if(this.responseText == 'done'){
        location.reload();
      } else {
        console.log('An error ocurred '+this.responseText);
      }
    }
  }
  xhttp.open("POST", "php/functions/drop_student_state.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("suid="+studid);
}
