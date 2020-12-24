var source;
var lastTestQuantity = NaN;
var progressTimer;

function getDataCommonInfo(){
	//Получает общую инофрмацию об неотправенных данных
	var dataStatusP = document.getElementById('data-text-loading');
	var xhttp = new XMLHttpRequest();

	dataStatusP.innerHTML = "<p id='data-text-loading'>Получаю данные<span id='loading-span'>...</span></p>";

	xhttp.onreadystatechange = function(){
		if(this.status == 404){
			xhttp.abort();
			dataStatusP.innerText = 'Не удалось провести запрос. Код ошибки: 404';
		}
		if(this.readyState == 4 && this.status == 200){
			var response = JSON.parse(this.response);
			let div = document.getElementById('ddy1');
			div.style.display = 'block';
			if(response.errors){
				div.innerHTML =  response.errors ;
			} else {
				if(response.notSent !== 0 ){
					if(lastTestQuantity !== response.notSent){
						lastTestQuantity = response.notSent
					//Убираем текст из строки статуса, скрываем див
					dataStatusP.innerHTML = '';
					dataStatusP.style.display = 'none';
					div.innerHTML = 'На данный момент кол-во неотправленных тестов: ' + response.notSent + '.';
					let buttonSend = document.createElement('button')
					buttonSend.onclick = () => {initiateSending('all')};
					buttonSend.textContent = 'Отправить';
					buttonSend.style.color = '#000000';
					buttonSend.style.fontSize = 'inherit';
					buttonSend.style.marginLeft = '1rem';
					div.append(buttonSend)
					div.append(document.createElement('hr'))

					//Таблица с данными неотправленных тестов
					let table = document.createElement('table')
					table.style.width = '100%';
					let tr = document.createElement('tr');
					let th1 = document.createElement('th');
					th1.innerText = 'Идентификатор';
					tr.append(th1);
					let th2 = document.createElement('th');
					th2.innerText = 'Дата';
					tr.append(th2)
					table.append(tr)
					for(i in response.testData){
						let tr = document.createElement('tr');
						let td1 = document.createElement('td');
						td1.innerText = '000001.';
						td1.innerText += fillWithZeroes(response.testData[i].student.GROUP_STUDENT_ID,6)+"."
						td1.innerText += fillWithZeroes(response.testData[i].student.ID,6)+"."
						td1.innerText += fillWithZeroes(response.testData[i].id,6)
						tr.append(td1)
						let td2 = document.createElement('td')
						td2.innerText = response.testData[i].date
						tr.append(td2)

						table.append(tr)
					}
					div.append(table)
					}	
				} else {
					div.innerHTML = 'Все тесты успешно отправленны.';		
				}
			}
		}
	}
	xhttp.open('POST', 'php/functions/dataHandle/getCommonData.php', true);
	xhttp.send();
}

function initiateSending(option){
	//Отсылает на страницу экспотра опцию экспорта, запускает интервал обновления полосы прогресса
	console.log(option)
	progressTimer = setInterval(()=>{
		console.log('Checking for updates...')
	},1000)		
}

function fillWithZeroes(string, desiredLenght){
	while(string.length < desiredLenght){
		string = "0"+string;
	}
	return string
}
