var autoUpdateStatus = setInterval(getConnections, 1000);
var forbiddenStatuses = ['--Выберите предмет--','','0','--Выберите модуль--','Предмет','--Предмет--','Модуль']
function ConfirmStudent(id) {
  var action = 'confirm'
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      getConnections();
    }
  };
  xhttp.open("POST", "php/functions/studentchange.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("action=" + action + "&id=" + id);
}

function DeconfirmStudent(id) {
  var action = 'deconfirm'
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      getConnections();
    }
  };
  xhttp.open("POST", "php/functions/studentchange.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("action=" + action + "&id=" + id);
}

function reload() {
  location.reload();
}

function LoadMouleMenu() {
  var sbj = document.getElementById('subject').value;
	if(!forbiddenStatuses.includes(sbj)){
	  var group = document.getElementById('group').value
    
	  var xhttp = new XMLHttpRequest();
	  xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	      document.getElementById("cmd1").innerHTML = this.responseText;
	    }
	  };
	  xhttp.open("POST", "php/functions/get_modules.php", true);
	  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	  xhttp.send("subject=" + sbj+"&group="+group);
	}
}

function getConnections() {
  console.log('getting connections');
  var group = document.getElementById('sgtuc1').value
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("scnt").innerHTML = this.responseText;
    }
  };
  xhttp.open("POST", "php/functions/get_connections.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("group=" + group);
}

function StartTest() {
  //Отправка теста в бд таблицу с активными тестами
  console.log('Start test');
  var xhttp = new XMLHttpRequest();
  //Тестируемый класс
  var group = document.getElementById('group').value;
  //Предмет
  var sbj = document.getElementById('subject').value;
  //Сам тест
  var module = document.getElementById('module-select').value;
  //Время на тест
  var timetodo = document.getElementById('test_time').value;
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      alert(this.responseText);
    }
  };
  xhttp.open("POST", "php/functions/start_test.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("class=" + group + "&module=" + module + "&subject=" + sbj + "&time=" + timetodo);
}

function ShowQuestions() {
  var module_name = document.getElementById('module-select').value;
  if(!forbiddenStatuses.includes(module_name)){
  var xhttp = new XMLHttpRequest();
  console.log(module_name);
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("tp1").innerHTML = this.responseText;
    }
  };
  xhttp.open("POST", "php/functions/get_question.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("module_name=" + module_name);
  }
}
function ShowSpecificVariants() {
  var variatnt = document.getElementById('varsel').value;
  variatnt.id = '123123123'
}

function ResetConnections() {
  console.log('Обнуление соединений');
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      console.log('Обнуление завершено успешно');
      getConnections();
    }
  };
  xhttp.open("POST", "php/functions/reset_connections.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("delete");
}

function addQuestion() {

}
