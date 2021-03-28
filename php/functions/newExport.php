<?php
session_start();

require_once '../../dtb/dtb.php';
require_once '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Conditional;

if(isset($user) & isset($password) & isset($server) & isset($database)){
    $dtb = new PDO("mysql:host=$server;dbname=$database;charset=utf8", $user, $password);
} else {
    $user = 'root';
    $password = '';
    $server = 'localhost';
    $database = 'sdo3';

    $dtb = new PDO("mysql:host=$server;dbname=$database;charset=utf8", $user, $password);
}

/** Сотрирует массив со студетами по кол-ву ошибок
 * @param ($students_array) array string
 * */
function sortStudentsByErrors($students_array){
    $sorted_array = [];
    $tmp = '';
    $sorted = false;
    $swichOccured = false;
    $loops = 0; //На всякий случай, если вдруг попадётся бесконечный цикл
    while(!$sorted){
        $loops++;
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
        if($loops>1000){
            break;
        }
    }
    $sorted_array = $students_array;
    return $sorted_array;
}

/**
 * Применяет оболочку со статистикой к таблице
 * @param ($startRow) int - Номер начальной колонны (отступ в строке)
 * @param ($startColumn) int
 * @param ($lenght) int - Длина таблицы (Кол-во вопросов, только они учавстуют в обработке данных)
 * @param ($height) int - Высота таблицы, кол-во учеников
 * @param ($endRow) int - На какой строке кончилась таблица
 * @param ($endColumn) int - На какой колонке кончилась таблица
 * */
function applyStatWrapper($startRow, $startColumn, $lenght, $height){
    global $sheet;
    //Применение горизонтального стиля
    for($i=0; $i<$lenght; $i++){
        $wrong_answers = 0;
        $correct_answers = 0;
        for($j=0; $j<$height; $j++){
            if($sheet->getCellByColumnAndRow($startRow+$i*3, $startColumn-($j+1))->getValue() === 0){
                $wrong_answers++;
            }else if($sheet->getCellByColumnAndRow($startRow+$i*3, $startColumn-($j+1))->getValue() === 1){
                $correct_answers++;
            }
        }
        $sheet->setCellValueByColumnAndRow($startRow+$i*3, $startColumn, $wrong_answers);
        $sheet->setCellValueByColumnAndRow($startRow+$i*3, $startColumn+1, round($wrong_answers/$height*100)."%");

//        $sheet->setCellValueByColumnAndRow($startRow+$i*3+4, $startColumn+1, calculateCellColorByCorrectPercent($wrong_answers/$height));

        $sheet->setCellValueByColumnAndRow($startRow+$i*3, $startColumn+1, round($wrong_answers/$height*100)."%");
        $sheet->getCellByColumnAndRow($startRow+$i*3, $startColumn+1)->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB(calculateCellColorByCorrectPercent($wrong_answers/$height));
    }
}

function calculateCellColorByCorrectPercent($percent){
    if(strpos($percent, '%') !== false){
        $percent = preg_replace('/%/', '', $percent)/100;
    }
    $red = round(256*$percent);
    $green = round(256*(1-$percent));
    if($red>255) $red = 255;
    if($red<0) $red = 0;

    if($green>255) $green = 255;
    if($green<0) $green = 0;

    $color = sprintf("%02x%02x%02x", $red, $green, 0);
    return $color;
}

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

    $s_column++; //Перейти на строку ниже

    //Условное форматирование
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

                //Данные
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
            $sheet->getCellByColumnAndRow($s_row+1, $s_column)->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB(calculateCellColorByCorrectPercent($percent/100));

            //TODO: Добавление форматирования процентов неправильных ответов по цветовой шкале

            $test_result['wrong_answers'] = $wrong_answers;
            $test_result['percent'] = ' '.$percent.'%';
            $students_unsorted[] = $test_result; //Добавление в массив для дальнешей сортировки

            $wrong_answers = 0;

            //КОНЕЦ ИНДИВИДУАЛЬНОГО УЧЕНИКА
        } else {
            $sheet->setCellValueByColumnAndRow($s_row, $s_column, "Не удалось загрузить результат, таблица результатов отсутсвует");
        }
        $s_column++;
    }

    applyStatWrapper(5, $s_column, $question_count, count($students_unsorted));

    //Пишем итоговую статистику
    $sheet->setCellValueByColumnAndRow(1, $s_column+2, 'Начало статистики');
    $sheet->setCellValueByColumnAndRow(1, $s_column+3, "Кол-во вопросов: $question_count");
    $sheet->setCellValueByColumnAndRow(1, $s_column+4, 'Конец статистики');

    $students_sorted = sortStudentsByErrors($students_unsorted);
    $sheet->fromArray($students_sorted, null, 'A'.($s_column+6));

    for($i=0; $i<count($students_sorted); $i++){ //Применение стиля для новой таблицы
        for($j=0; $j<$question_count; $j++){
            $sheet->getCellByColumnAndRow($j*3+5, $s_column+6+$i)->getStyle()->setConditionalStyles($all_conditional_styles);
            if($j == $question_count-1){
                $sheet->getCellByColumnAndRow($j*3+7, $s_column+6+$i)->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB(calculateCellColorByCorrectPercent($students_sorted[$i]["percent"]));
            }
        }
    }

    $s_column += 6 + count($students_sorted);

    $s_row = 5; //Передвинуть указатель для статистики
    applyStatWrapper($s_row, $s_column, $question_count, count($students_sorted));
    //Вывод файла
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
