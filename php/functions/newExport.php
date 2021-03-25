<?php
session_start();

require_once '../../dtb/dtb.php';
if(isset($user) & isset($password) & isset($server) & isset($database)){
    $dtb = new PDO("mysql:host=$server;dbname=$database;charset=utf8", $user, $password);
} else {
    $user = 'root';
    $password = '';
    $server = 'localhost';
    $database = 'sdo3';

    $dtb = new PDO("mysql:host=$server;dbname=$database;charset=utf8", $user, $password);
}

function sortStudentsByErrors($students_array){
    $sorted_array = [];
    $tmp = '';
    $sorted = false;
    $swichOccured = false;
    while(!$sorted){   
        $swichOccured = false;
        for($i = 0; $i<count($students_array)-1; $i++){
            if($students_array[$i]['wrong_answers'] > $students_array[$i+1]['wrong_answers']){
                $swichOccured = true;
                $tmp = $students_array[$i];
                $students_array[$i] = $students_array[$i+1];
                $students_array[$i+1] = $tmp;
            }
        }
        if(!$swichOccured){
            $sorted = true;
        }
    }
    $sorted_array = $students_array;
    return $sorted_array;
}

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Conditional;

//TODO: Опции выборки 

$sql = 'SELECT * FROM test_results';
$stm = $dtb->query($sql);
if($stm){
    //Указатели на столбец/строку (Точнее сколько ячеек было пройденно в ряду/колонне, да названия перепутались но если подумать не так страшно)
    $s_column = 1; 
    $s_row = 1;

    //Сама таблица 
    $spreadSheet = new Spreadsheet();
    $sheet = $spreadSheet->getActiveSheet(); //Рабочий лист 

    //Заголовки колонн
    $sheet->setCellValueByColumnAndRow(1, $s_column, 'Номер записи');
    $sheet->setCellValueByColumnAndRow(2, $s_column, 'ФИО'); $s_column++; //Перейти на строку ниже Условное форматирование 
    $condition_correctness_true = new Conditional(); 
    $condition_correctness_true->setConditionType(Conditional::CONDITION_CELLIS) 
                        ->setOperatorType(Conditional::OPERATOR_EQUAL) 
                        ->addCondition('0'); 
    $condition_correctness_true->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)->getEndColor()->setARGB(Color::COLOR_RED);
    
    $condition_correctness_false = new Conditional();
    $condition_correctness_false->setConditionType(Conditional::CONDITION_CELLIS)
                        ->setOperatorType(Conditional::OPERATOR_EQUAL)
                        ->addCondition('1');
    $condition_correctness_false->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)->getEndColor()->setARGB(Color::COLOR_GREEN);

    $all_conditional_styles[] = $condition_correctness_true; 
    $all_conditional_styles[] = $condition_correctness_false;

    $hideUnnecessaryColumns = true;
    $enable_hand_formatting = false;

    //Для составления второй отсортированной таблицы 
    $students_unsorted = [];
    

    while($row = $stm->fetch(PDO::FETCH_ASSOC)){ //Итерация через все результаты 
        //Записывам id/фио
        $sheet->setCellValueByColumnAndRow(1, $s_column, $row['id']); 
        $sheet->setCellValueByColumnAndRow(2, $s_column, $row['student']);
        $sql = "SELECT * FROM tr_".$row['id']."";

        $test_result = [];
        $test_result['id'] = $row['id'];
        $test_result['student'] = $row['student'];

        $s_row = 3;

        $question_count = 0; 
        $wrong_answers = 0;
        
        if($dtb->query($sql)){
            $result = $dtb->query($sql);
            while($tr_row = $result->fetch(PDO::FETCH_ASSOC)){ //Итерация по вопросам конкретного теста 
                //Записывание название колонны
                $question_count++;
                $sheet->setCellValueByColumnAndRow($s_row,   1, 'Задание '.$tr_row['id']);
                $sheet->setCellValueByColumnAndRow($s_row+1, 1, 'Вариант');
                $sheet->setCellValueByColumnAndRow($s_row+2, 1, $tr_row['id']);

                //Данные в массив для сортировки 
                $test_result["Задание_$question_count"] = $tr_row['id'];
                $test_result["Вариант_$question_count"] = $tr_row['Question_var'];
                $test_result[$question_count] = (($tr_row['Correctness']) ? "1" : "0");

                //1нные 
                $sheet->setCellValueByColumnAndRow($s_row,   $s_column, $tr_row['id']);
                $sheet->setCellValueByColumnAndRow($s_row+1, $s_column, $tr_row['Question_var']);
                $sheet->setCellValueByColumnAndRow($s_row+2, $s_column, (($tr_row['Correctness']) ? "1" : "0"));
    
                if($tr_row['Correctness']){ //Условное форматирование не работает на ДА и НЕТ, но работает на 0 и 1
                    if($enable_hand_formatting){
                        $sheet->getCellByColumnAndRow($s_row+2, $s_column)->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB(Color::COLOR_GREEN);
                    }
                } else {
                    if($enable_hand_formatting){
                        $sheet->getCellByColumnAndRow($s_row+2, $s_column)->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB(Color::COLOR_RED);
                    }
                    $wrong_answers++;
                }
                
                if($hideUnnecessaryColumns){
                $sheet->getColumnDimensionByColumn($s_row+1)->setVisible(false);               
                $sheet->getColumnDimensionByColumn($s_row)->setVisible(false);               
                }

                //Применение условного форматирования 
                $sheet->getCellByColumnAndRow($s_row+2, $s_column)->getStyle()->setConditionalStyles($all_conditional_styles);
               
                $s_row+=3; //Прошли три ячейки
            }
            
            //Запись статистики ученика 
            $sheet->setCellValueByColumnAndRow($s_row, $s_column, "$wrong_answers");
            $sheet->setCellValueByColumnAndRow($s_row, 1, "Ошибки");

            if($wrong_answers != 0){
                $percent = round($wrong_answers/$question_count*100);
            } else {
                $percent = 0;
            }
            $sheet->setCellValueByColumnAndRow($s_row+1, $s_column, ' '.$percent.'%');

            $test_result['wrong_answers'] = $wrong_answers;
            $test_result['percent'] = ' '.$percent.'%';
            $students_unsorted[] = $test_result;

            $wrong_answers = 0;
        } else { 
            $sheet->setCellValueByColumnAndRow($s_row, $s_column, "Не удалось загрузить результат, таблица результатов отсутсвует");
        }
        $s_column++;
    }
    //Пишем итоговую статистику 
    $sheet->setCellValueByColumnAndRow(1, $s_column+2, 'Начало статистики');
    $sheet->setCellValueByColumnAndRow(1, $s_column+3, "Кол-во вопросов: $question_count");
    $sheet->setCellValueByColumnAndRow(1, $s_column+4, 'Конец статистики');
 
    $students_sorted = sortStudentsByErrors($students_unsorted);
    $sheet->fromArray($students_sorted, null, 'A'.($s_column+6));
    
    for($i=0; $i<count($students_sorted); $i++){ //Применение стиля для новой таблицы
        for($j=0; $j<count($students_sorted[0]); $j){

        }
    }

   
    $writer = new Xlsx($spreadSheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="demo.xlsx"');
    header('Cache-Control: max-age=0');
    header('Expires: Fri, 11 Nov 2011 11:11:11 GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: cache, must-revalidate');
    header('Pragma: public');
    $writer->save('php://output');
}else{
    die("Database error, query ($sql) not successfull");
}

?>
