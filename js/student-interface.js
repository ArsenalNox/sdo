
function showLoginButton(){
  document.getElementById('sl').style.display = 'block';
}

function shuffle_divs() {
  //Перемешивает дивы с вопросамиЮ нормерует их в правильном порядке
  var parent = $("#tfs1");
  var divs = parent.children();
  var selector
  var question_num = 1;
  while (divs.length) {
    selector = divs.splice(Math.floor(Math.random() * divs.length), 1);
    selector[0].id = 'q'+question_num;
    parent.append(selector[0]);
    $("#q"+question_num).children("h4").text('Задание № '+question_num);
    question_num++;
  }
}
shuffle_divs();
