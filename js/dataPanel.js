var source

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
			let response = JSON.parse(this.response);
			let div = document.getElementById('ddy1');
			div.style.display = 'block';
			if(response.errors){
				div.innerHTML = 'При запросе произошла, текст ошибки:" ' + response.errors + "'";
			} else {
				if(response.notSent !== 0 ){
					dataStatusP.innerHTML = '';
					dataStatusP.style.display = 'none';
					div.innerHTML = 'На данный момент кол-во неотправленных тестов: ' + response.notSent + '.';
					let buttonSend = document.createElement('button')
					buttonSend.onclick = () => {initiateSending('all')};
					buttonSend.textContent = 'Отправить';
					div.append(buttonSend)
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
	console.log(option)
	var xhttp = new XMLHttpRequest()
	xhttp.open('POST', 'php/functions/dataHandle/sendData.php', true);
	xhttp.send()
	source = new EventSource("php/functions/dataHandle/sendData.php");
	source.onmessage = function(e) {
		console.log(" a "+e);
	}
	
}
