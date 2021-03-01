<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['content'])){
        if(strlen($_POST['content'])>2){
            $dtb = new PDO('mysql:host=localhost;dbname=sdo', 'root', '');
            $stm = $dtb->prepare('INSERT INTO `reviews` (`content`, `date`) VALUES (?, ?)');
            $stm->bindParam(1, $_POST['content']); 
            $date = date('Y-m-d H:i:s');
            $stm->bindParam(2, $date);
            if($stm->execute()){
                echo json_encode(array('message'=>'Отзыв успешно отправлен', 'succes' => true));
            }else{
                echo json_encode(array('message'=>'Ошибка базы данных', 'succes' => false));
            }
        }else{
           echo json_encode(array('message'=>'Соедржимое отзыва не может быть пустым', 'succes' => false));
        }
    } else {
        echo json_encode(array('message'=>'content not set', 'succes' => false));
    }
} else {
    echo json_encode(array('message'=>'invalid request method', 'succes' => false));
}

