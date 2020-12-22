function showAllResults() {
  //Выводит запрашиваемые данные в таблицу
  try {
    var request = document.getElementById('dvm1').value;
  } catch {
    var request = 'none';
  }
  var method = document.getElementById('ms1').value;
  var sort = document.getElementById('ss1').value;
  var additionalOptions = processOptions();
  console.log('Запрос данных для таблицы...');
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

function processOptions() {
  //Обрабатывает дополнительные опции
  var result = '';
  var type = '';
  var processedOptions = '&addoptcount=0';
  if (document.getElementById('s-holder').style.display == 'grid') {
    var optionCount = document.getElementById('oc').value;
    var j = 0;
    for (var i = 1; i <= optionCount; i++) {
      if (document.getElementById('optstate' + i).value == 'displayed') {
        j++;
        result += '&addoption' + j + '=' + document.getElementById('ao' + i).value;
        type += '&optiontype' + j + '=' + document.getElementById('ao' + i).name;
      }
    }
    processedOptions = "&addoptcount=" + j;
  }
  return processedOptions + result + type;
}

function exportCurrentTable() {
  //Скорее всего придётся переделать на ссылку и просто открывать export.php и брать из сессии sql
  console.log('Экспортирую таблци......');
}

function showSimilar(id) {
  console.log(id)
}

function showQuetionPopUp(resultId, questionNumber) {
  console.log(resultId, questionNumber);
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      //Создаём popup с данными и показываем
      let popUpDiv = document.createElement('div');
      popUpDiv.className = 'popup-wrapper';
      popUpDiv.id = 'pq';
      popUpDiv.innerHTML = this.responseText;
      document.body.append(popUpDiv);
      document.addEventListener('click', (e) => {
        if (!e.path.includes(popUpDiv) || (e.target.id == 'colse-popup-button')) {
          popUpDiv.remove();
        }
      })
    }
  }
  xhttp.open("POST", "php/functions/showSpecificQuestion.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("resultId=" + resultId + "&questionNumber=" + questionNumber);
}

function sortTable(n) {
  try {
    var table, rows, switching, i, x, y, shouldSwitch, dir
    var switchcount = 0;
    table = document.getElementById('table-1');
    switching = true;
    //Set the sorting direction to ascending:
    dir = "asc";
    /*Make a loop that will continue until
    no switching has been done:*/
    while (switching) {
      //start by saying: no switching is done:
      switching = false;
      rows = table.rows;
      /*Loop through all table rows (except the
      first, which contains table headers):*/
      for (i = 1; i < (rows.length - 1); i++) {
        //start by saying there should be no switching:
        shouldSwitch = false;
        /*Get the two elements you want to compare,
        one from current row and one from the next:*/
        x = rows[i].getElementsByTagName("TD")[n];
        y = rows[i + 1].getElementsByTagName("TD")[n];
        /*check if the two rows should switch place,
        based on the direction, asc or desc:*/
        if (dir == "asc") {
          if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
            //if so, mark as a switch and break the loop:
            shouldSwitch = true;
            break;
          }
        } else if (dir == "desc") {
          if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
            //if so, mark as a switch and break the loop:
            shouldSwitch = true;
            break;
          }
        }
      }
      if (shouldSwitch) {
        /*If a switch has been marked, make the switch
        and mark that a switch has been done:*/
        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
        switching = true;
        //Each time a switch is done, increase this count by 1:
        switchcount++;
      } else {
        /*If no switching has been done AND the direction is "asc",
        set the direction to "desc" and run the while loop again.*/
        if (switchcount == 0 && dir == "asc") {
          dir = "desc";
          switching = true;
        }
      }
    }


  } catch (err) {
    console.log(err);
  }
}
