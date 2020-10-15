function GetGroupNames(){
  var xhttp = new XMLHttpRequest();
  var student_group = document.getElementById('student_group_selector').value;
  console.log('Requesting names for ', student_group);
  xhttp.onreadystatechange=function() {
      if (this.readyState == 4 && this.status == 200) {
        console.log('Done!', this.responseText);
        document.getElementById('group_names').innerHTML = this.responseText;
      }
    };
  xhttp.open("POST", "php/functions/get_name.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("group=" + student_group);
}

function LoadTests(){
  var xhttp = new XMLHttpRequest();
  var student_group = document.getElementById('student_group').textContent;
  xhttp.onreadystatechange=function() {
      if (this.readyState == 4 && this.status == 200) {
        console.log(student_group);
        document.getElementById('mtf').innerHTML = this.responseText;
      }
    };
  xhttp.open("POST", "php/functions/load_avaliable_tests.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("group=" + student_group);
}

function SendStudentInfo(){
  var xhttp = new XMLHttpRequest();
  var new_name = document.getElementById('group_names').value;
  var ip = document.getElementById('ip').textContent;
  var student_group = document.getElementById('student_group_selector').value;
  xhttp.onreadystatechange=function() {
      if (this.readyState == 4 && this.status == 200) {
        location.reload();
      }
    };
  xhttp.open("POST", "php/functions/insert_new_student_name.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("new_name=" + new_name + "&ip=" + ip + "&nl=" + student_group);
}

function startTest(id){
  var test_id = id;
  document.getElementById('mtf').remove();
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange=function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById('test').innerHTML = this.responseText;
      }
    };
  xhttp.open("POST", "php/functions/student_start_test.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("test_id=" + test_id);
}

function getStatus(){
  var test_id = id;
  document.getElementById('mtf').remove();
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange=function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById('test').innerHTML = this.responseText;
      }
    };
  xhttp.open("POST", "php/functions/student_start_test.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("test_id=" + test_id);
}
