
function ConfirmStudent(id){
    var action  = 'confirm'
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "studentchange.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=" + action +"&id="+id);
    setTimeout(reload, 100 )
}

function DeconfirmStudent(id){
    var action  = 'deconfirm'
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "studentchange.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=" + action +"&id="+id);
    setTimeout(reload, 100 )
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
