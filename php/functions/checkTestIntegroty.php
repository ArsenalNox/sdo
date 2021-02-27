<?php
header('Content-type','text\json');
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $dtb = new PDO('mysql:host=localhost;dbname=sdo', 'root', '');
    $len = $_POST['len'];
    $id  = $_POST['id'];
    $stm = $dtb->prepare('SELECT test_dir FROM current_test WHERE id=?');
    $stm->bindParam(1, $id);
    if($stm->execute()){
        $data = [];
        $row=$stm->fetch(PDO::FETCH_ASSOC);
        $stm_q = $dtb->prepare('SELECT Questions FROM new_module WHERE Name=? ');
        $stm_q->bindParam(1, $row['test_dir']);
        if($stm_q->execute()){
            $qnum = 0;
            $row = $stm_q->fetch(PDO::FETCH_ASSOC);
            $quest_file = file_get_contents('../../'.$row['Questions']);
            $test = json_decode($quest_file, true);
            foreach($test as $quest){
                if(isset($quest['QUESTION_NUM'])){
                    $qnum = $quest['QUESTION_NUM'];
                }
            }
            $data[] = array( 'question_quantity' => $qnum);
            echo json_encode($data);
        } else { 
            $data['error'] = 'second step error';
            $data['queryData'] = $row;
            echo json_encode($data);
        }
      
    }else{
        $data = ['error'=>'database error'];
        echo json_encode($data);
    }
}else{
    $data = ['error'=>'acces forbidden'];
    echo json_encode($data);
}
