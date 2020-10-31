function showAllResultsOfModule(){
    module = document.getElementById('mds1').value;
    console.log('Запрашиваю результаты модуля ' + module);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        console.log('Готово!');
        document.getElementById('tlw1').innerHTML = this.responseText;
      }
    };
    xhttp.open("POST", "php/functions/get_module_results.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("module=" + module);
}
