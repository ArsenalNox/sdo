<?php
include_once "dtb/dtb.php";

// TODO: Превью экспорта таблицы прямо в форме (5-10 строк из таблицы)
?>
<html lang="ru">
<head>
    <link rel="stylesheet" href="css/main.css">
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель управления</title>
    <style media="screen">
      .export-type-selection{
        position: relative;
        width: 70%;
        border: 1px black solid;
        border-radius: 12px;
        top: 30%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 3rem;
        background-color: #f7f7f7d1;
      }
      .export-link{

      }
    </style>
</head>
<body>

  <section class="export-type-selection">
    <a href="panel.php" class="to-crmd">
      <button>← Назад</button>
    </a>
    <form class="" action="php/functions/export.php" method="post" id='exf'>
      <p> Экспортировать таблицу:
      <select class="" name="export_option" id='sm' onchange="defineExportMethod()">
        <option value="null">---</option>
        <option value="all_all">Все результаты за всё время</option>
        <option value="all_time">Все результаты за промежуток времени</option>
        <option value="spec_all">Результаты класса за всё время</option>
        <!-- <option value="spec_time">Результаты класса за промежуток времени</option>
        <option value="all_all">Результаты ученика за всё время</option>
        <option value="all_all">Результаты ученика за промежуток времени</option> -->
      </select> </p>
      <fieldset id='addinfo'>

      </fieldset>
    </form>
  </section>

<script type="text/javascript">
  function defineExportMethod(){
    var selection = document.getElementById('sm').value;
    console.log(selection);
    document.getElementById('addinfo').remove();
    let fieldset = document.createElement('fieldset');
    fieldset.id = 'addinfo'
    document.getElementById('exf').append(fieldset);
    switch (selection) {
      case "all_all":
          let button = document.createElement('button');
          button.type = 'submit';
          button.innerText = 'Экспортировать'
          document.getElementById('addinfo').append(button);
        break;

      case "all_time":
          let input_first = document.createElement('input');
          let input_second = document.createElement('input');
          input_first.type = 'date';
          input_first.name = 'first_date';
          input_second.type = 'date';
          input_second.name = 'second_date';
          let p = document.createElement('p');
          p.innerText = '--'
          document.getElementById('addinfo').append(input_first, p, input_second)

          let button3 = document.createElement('button');
          button3.type = 'submit';
          button3.innerText = 'Экспортировать'
          document.getElementById('addinfo').append(button3);
        break;

      case "spec_all":
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange=function() {
                if (this.readyState == 4 && this.status == 200) {
                  document.getElementById('addinfo').innerHTML = this.responseText;
                  let button2 = document.createElement('button');
                  button2.type = 'submit';
                  button2.innerText = 'Экспортировать'
                  document.getElementById('addinfo').append(button2);
                }
              };
            xhttp.open("POST", "php/functions/getclasses.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("group");
        break;
    }
  }
</script>

</body>
