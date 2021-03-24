<?php
session_start();

require_once '../../dtb/dtb.php';
if(isset($user) & isset($password) & isset($server) & isset($database)){
    $dtb = new PDO("mysql:host=$server;dbname=$database;charset=utf8", $user, $password);
} else {
    $user = 'root';
    $password = '';
    $server = 'localhost';
    $database = 'sdo';

    $dtb = new PDO("mysql:host=$server;dbname=$database;charset=utf8", $user, $password);
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
    $sheet->setCellValueByColumnAndRow(2, $s_column, 'ФИО');
    
    $s_column++;

    //Условное форматирование 
    $condition_correctness_true = new Conditional();
    $condition_correctness_true->setConditionType(Conditional::CONDITION_CELLIS)
                        ->setOperatorType(Conditional::OPERATOR_EQUAL)
                        ->addCondition('Нет');
    $condition_correctness_true->getStyle()->getFont()->getColor()->setARGB(Color::COLOR_RED);
    
    $condition_correctness_false = new Conditional();
    $condition_correctness_false->setConditionType(Conditional::CONDITION_CONTAINSTEXT)
                        ->setOperatorType(Conditional::OPERATOR_CONTAINSTEXT)
                        ->addCondition('Да');
    $condition_correctness_false->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)->getEndColor()->setARGB(Color::COLOR_GREEN);

    $all_conditional_styles[] = $condition_correctness_true;
    $all_conditional_styles[] = $condition_correctness_false;

    $hideUnnecessaryColumns = true;

    while($row = $stm->fetch(PDO::FETCH_ASSOC)){ //Итерация через все результаты 
        //Записывам id/фио
        $sheet->setCellValueByColumnAndRow(1, $s_column, $row['id']); 
        $sheet->setCellValueByColumnAndRow(2, $s_column, $row['student']);
        $sql = "SELECT * FROM tr_".$row['id']."";
        
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

                //Данные 
                $sheet->setCellValueByColumnAndRow($s_row,   $s_column, $tr_row['id']);
                $sheet->setCellValueByColumnAndRow($s_row+1, $s_column, $tr_row['Question_var']);
                $sheet->setCellValueByColumnAndRow($s_row+2, $s_column, (($tr_row['Correctness']) ? "Да" : "Нет"));

                if($tr_row['Correctness']){ //Условное форматирование не работает на ДА и НЕТ, но работает на 0 и 1
                    $sheet->getCellByColumnAndRow($s_row+2, $s_column)->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB(Color::COLOR_GREEN);
                } else {
                    $sheet->getCellByColumnAndRow($s_row+2, $s_column)->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB(Color::COLOR_RED);
                    $wrong_answers++;
                }
                
                if($hideUnnecessaryColumns){
                $sheet->getColumnDimensionByColumn($s_row+1)->setVisible(false);               
                $sheet->getColumnDimensionByColumn($s_row)->setVisible(false);               
                }

                //Применение условного форматирования 
                $sheet->getCellByColumnAndRow($s_row+2, $s_column)->getStyle()->setConditionalStyles($all_conditional_styles);
                $sheet->getCellByColumnAndRow($s_row+2, $s_column)->getStyle()->getFont()->setBold(true);
               
                $s_row+=3; //Прошли три ячейки
            }
        } else {
            $sheet->setCellValueByColumnAndRow($s_row, $s_column, "Не удалось загрузить результат, таблица результатов отсутсвует");
        }
        $sheet->getCellByColumnAndRow($s_row+1, 1, 'Ошибки');
        $sheet->getCellByColumnAndRow($s_row+1, $s_column, $wrong_answers);
        $sheet->getCellByColumnAndRow($s_row+2, $s_column, round($question_count/100*$wrong_answers)."%");

        $s_column++;
    }
    //Пишем итоговую статистику 
    $sheet->setCellValueByColumnAndRow(1, $s_column+2, 'НАЧАЛО СТАТИСТИКИ');
    $sheet->setCellValueByColumnAndRow(1, $s_column+3, "Кол-во вопросов: $question_count");

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
