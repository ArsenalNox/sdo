//Переменные состояния
var t_not = 'test_not_selected';
var t_ong = 'test_started';
var t_cmp = 'completed';
//Таймер
var timer

function GetGroupNames() {
  //Получает все имена класса
  var xhttp = new XMLHttpRequest();
  var student_group = document.getElementById('student_group_selector').value;
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById('group_names').innerHTML = this.responseText;
      showLoginButton();
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
  window.test_id = id;
  console.log(id);
  document.getElementById('mtf').remove();
  var xhttp = new XMLHttpRequest();
  document.getElementById('nauth').style.display = 'none';
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById('test').innerHTML = this.responseText;
      //Проверям, все ли вопросы дошли
      checkTestIntegrity(document.querySelectorAll('.task').length, window.test_id)
      document.title = document.getElementById('ntl').value;
      shuffle_divs();
      loadReferenceBook()	
      tick();
      timer = setInterval(tick, 1000);
    }
  };
  xhttp.open("POST", "php/functions/student_start_test.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("test_id=" + window.test_id);
}

function getStatus() {
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

function stopTest(reason){
  if(reason=='timeout'){
    document.getElementById('tfs1').submit()
  }
  else if (confirm("Вы действительно хотите прекратить выполнение теста?")){
    location.reload();
  }
}

function tick(){
  var timeToComplete = document.getElementById('ttc').value*60;
  seconds++;
  if(seconds == 60){
    minutes++;
    seconds = 0;
  }
  let timePassedSeconds = seconds+minutes*60;
  let timeLeftSeconds = (timeToComplete - timePassedSeconds);
  let timeLeftMinutes = (timeLeftSeconds - timeLeftSeconds%60)/60;
  timeLeftSeconds = timeLeftSeconds%60;
  document.getElementById('timer').innerText = timeLeftMinutes + ':' + timeLeftSeconds;
  if( (timeToComplete-timePassedSeconds) < 0 ){
      clearInterval(timer);
      stopTest('timeout');
      alert('Время на выполнение теста вышло, \nответы будут записанны как есть.');
  }
}

function loadReferenceBook(){
	var xhttp = new XMLHttpRequest();
  	xhttp.onreadystatechange = function() {
    		if (this.readyState == 4 && this.status == 200) {
      			if(this.responseText == 'includes'){
				console.log('1')
				let divw = document.createElement('div')
				divw.className = 'reference-wrapper'
				divw.innerHTML = "<a href='reference-book.php' target='_blank'> Открыть справочные материалы </a> "
  				document.body.append(divw)	
			}else{
				console.log(this.responseText)
			}
		}	
	}
	xhttp.open("POST", "reference-book.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("test_request=1");
}

function checkTestIntegrity(len, testId){
  console.log(len, testId);
  var xhttp = new XMLHttpRequest();
  	xhttp.onreadystatechange = function() {
    		if (this.readyState == 4 && this.status == 200) {
          try{
            resp = JSON.parse(this.response)
            if(parseInt(resp[0].question_quantity) !== len){
              startTest(testId);
            }
          }catch{
            console.log(this.response);
          }
        } 
		}	
	xhttp.open("POST", "php/functions/checkTestIntegroty.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("len="+len+"&id="+testId);
}

function skipQuestion(element){
  if(confirm('Вы уверенны что хотите пропустить это задание?')){
    var inputs = element.querySelectorAll('input')
    element.style.opacity = 0.5
    console.log(inputs);
    for(let i=0; i< inputs.length; i++){
      inputs[i].required = false
      console.log(inputs[i]);
    }
    var button = document.getElementById('s'+element.id)
    button.innerText = 'Вопрос пропущен'
    button.onclick = false
  }
}