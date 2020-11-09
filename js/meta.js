function showAllResults() {
  //Выводит запрашиваемые данные в таблицу
  var request = document.getElementById('dvm1').value;
  var method = document.getElementById('ms1').value;
  var sort = document.getElementById('ss1').value;
  var additionalOptions = processOptions();
  console.log(' Запрос ' + method + ", " + request + ", " + sort + ' дополнительные опции: ' + additionalOptions);
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
  xhttp.send("method=" + method + "&data=" + request + "&sort=" + sort + additionalOptions);
}

function loadAssociatedData() {
  //Загружает соответсвующий выпадающий список с данными
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

function loadAdditionalOptions() {
  //Загружент соответсвующие дополнительные опции
  var option = document.getElementById('ms1').value;
  console.log(' Запрос соответствующих дополнительных опций для ' + option);
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      console.log('Готово! (2)');
      document.getElementById('s-holder').innerHTML = this.responseText;
    }
  };
  xhttp.open("POST", "php/functions/showAdditionalOptions.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("data=" + option);
}

function showOption(id) {
  //Скрывает/Показывет допольнительные опции 
  var state = document.getElementById('optstate' + id).value;
  console.log(' Изменяю отоброжение опции ' + id);
  switch (state) {
    case 'hidden':
      document.getElementById('opt' + id).style.display = 'grid';
      document.getElementById('optstate' + id).value = 'displayed';
      break;
    case 'displayed':
      document.getElementById('opt' + id).style.display = 'none';
      document.getElementById('optstate' + id).value = 'hidden';
      break;
  }
}

function processOptions(){
  //Обрабатывает дополнительные опции
  var result = '';
  var type = '';
  var processedOptions = '&addoptcount=0';
  if(document.getElementById('s-holder').style.display == 'grid'){
    var optionCount = document.getElementById('oc').value;
    var j = 0;
    for (var i = 1; i <= optionCount; i++) {
        if(document.getElementById('optstate'+i).value == 'displayed'){
          j++;
          result += '&addoption' + j + '=' + document.getElementById('ao'+i).value;
          type += '&optiontype' + j + '=' + document.getElementById('ao'+i).name;
        }
      }
    processedOptions = "&addoptcount=" + j;
  }
  return processedOptions+result+type;
}

function exportToExcel(sql) {
  //?????
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      console.log('Готово! (2)');
      document.getElementById('s-holder').innerHTML = this.responseText;
    }
  };
  xhttp.open("POST", "php/functions/showAdditionalOptions.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("data=" + option);
}

function exportCurrentTable(){
  //Скорее всего придётся переделать на ссылку и просто открывать export.php и брать из сессии sql
  console.log('Экспортирую таблци......');
}
