function showAllResults(){
    //Выводит запрашиваемые данные в таблицу
    var request = document.getElementById('dvm1').value;
    var method = document.getElementById('ms1').value;
    var sort = document.getElementById('ss1').value;
    console.log('Запрос ' + method + ", " + request);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        console.log('Готово!');
        document.getElementById('tlw1').style.display = 'grid';
        document.getElementById('tlw1').innerHTML = this.responseText;
      }
    };
    xhttp.open("POST", "php/functions/showqueryresult.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("method="+ method +"&data=" + request + "&sort=" + sort);
}

function loadAssociatedData(){
  var request = document.getElementById('ms1').value;
  console.log('Запрос данных для ' + request);
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      console.log('Готово! (1)');
      document.getElementById('dsw1').style.display = 'grid';
      document.getElementById('dsw1').innerHTML = this.responseText;
    }
  };
  xhttp.open("POST", "php/functions/showassocdata.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("data=" + request);
  loadAdditionalOptions()
}

function loadAdditionalOptions(){
  var option = document.getElementById('ms1').value;
  console.log('Запрос соответствующих дополнительных опций для ' + option);
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      console.log('Готово! (2)');
      document.getElementById('apt2').innerHTML = this.responseText;
    }
  };
  xhttp.open("POST", "php/functions/showAdditionalOptions.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("data=" + option);
}
