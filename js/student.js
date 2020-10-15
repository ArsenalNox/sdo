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
