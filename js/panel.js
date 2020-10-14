
function ConfirmStudent(id){
    var action  = 'confirm'
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange=function() {
        if (this.readyState == 4 && this.status == 200) {
          getConnections();
        }
      };
    xhttp.open("POST", "studentchange.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=" + action +"&id="+id);
}

function DeconfirmStudent(id){
    var action  = 'deconfirm'
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange=function() {
        if (this.readyState == 4 && this.status == 200) {
          getConnections();
        }
      };
    xhttp.open("POST", "studentchange.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=" + action +"&id="+id);
}

function reload(){
    location.reload();
}

function LoadMouleMenu(){
  var sbj = document.getElementById('subject').value;
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange=function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("cmd1").innerHTML = this.responseText;
      }
    };
  xhttp.open("POST", "php/functions/get_modules.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("subject=" + sbj);
}

function getConnections(){
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange=function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("scnt").innerHTML = this.responseText;
      }
    };
  xhttp.open("POST", "php/functions/get_connections.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("no"+0);
}

function StartTest(){
  //Отправка теста в бд таблицу с активными тестами
  console.log('Start test');
  var xhttp = new XMLHttpRequest();
  //Тестируемый класс
  var group = document.getElementById('group').value;
  //Предмет
  var sbj = document.getElementById('subject').value
  //Сам тест
  var module = document.getElementById('module-select').value;
  //?Время на тест
  var timetodo = 'Test';
  xhttp.onreadystatechange=function() {
      if (this.readyState == 4 && this.status == 200) {
        alert(this.responseText);
      }
    };
  xhttp.open("POST", "php/functions/start_test.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("class=" + group + "&module=" + module + "&subject=" + sbj);
}

function ShowQuestions(){
  var xhttp = new XMLHttpRequest();
  var module_name = document.getElementById('module-select').value;
  xhttp.onreadystatechange=function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("tp1").innerHTML = this.responseText;
      }
    };
  xhttp.open("POST", "php/functions/get_question.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("module_name="+module_name);
}
