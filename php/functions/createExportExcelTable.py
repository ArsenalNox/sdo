import xlsxwriter
import sys
import mysql.connector
from operator import itemgetter
from xlsxwriter import utility
#-----------------------

def writeTable(sheet, students:list, row:int, column:int, writeHeader:bool):
    """
    Печатает предоставленный массив в таблицу 
    Возвращает высоту созданной таблицы 
    """
    
    startColumn = column
    startRow = row 
    columnsToCheck = []
    tableHeight = 0
    wrongs = {}

    if(writeHeader): #записать названия колонок и скрыть ненужные 
        for attr in students[0]:
            print(attr)
            if attr in headerNames:
                sheet.write(0, column, headerNames[attr])
            if attr.isdigit():
                sheet.write(0, column, attr)               
            if 'test_num_' in attr:
                sheet.write(0, column, 'Номер задания')
                sheet.set_column(column, column, None, None, {'hidden': True})
            if 'test_var_' in attr: 
                sheet.write(0, column, 'Вариант')
                sheet.set_column(column, column, None, None, {'hidden': True})

            column += 1
        column = startColumn

    for student in students: #Записываение всех данных массива
        tableHeight+=1
        for attr in student:
            
            if attr.isdigit(): #Если колонна - данных о задании 
                if attr not in wrongs: #Если нет в словере 
                    wrongs[attr] = {'col': 0, 'val': 0}
                if attr in wrongs:
                    if student[attr] == 0: #Увеличить значение если ответ неправильный 
                        wrongs[attr]['val'] += 1

                if column not in columnsToCheck: #Добавить колонну для будующей проверки всех результатов вопроса 
                    columnsToCheck.append(column)
                    wrongs[attr]['col'] = column

                if student[attr] == 1: #Если ответ правильный окрасить в зелёный 
                    sheet.write(row, column, student[attr], workBook.add_format({'bg_color':'#00DD00'}))
                else:
                    sheet.write(row, column, student[attr], workBook.add_format({'bg_color':'#DD0000'}))
                
            else: 
                if '%' in str(student[attr]):
                    percent = int(student[attr].split('%')[0])/100
                    sheet.write(row, column, student[attr], workBook.add_format({'bg_color': getCellColorByPercent(percent, True)}))
                    print('Coloring percentile cell with vale {}'.format(percent) )
                else: 
                    sheet.write(row, column, student[attr])

            column += 1
        row += 1 
        column = startColumn

    for stat in wrongs: #Пройтись по неправильным вопросам и записать
        sheet.write(startRow+tableHeight, wrongs[stat]['col'], wrongs[stat]['val'])
        sheet.write(startRow+tableHeight+1, wrongs[stat]['col'], wrongs[stat]['val']/tableHeight*100, workBook.add_format({'bg_color': getCellColorByPercent(wrongs[stat]['val']/tableHeight, False)}))
    tableHeight+=3
    print(columnsToCheck, tableHeight, startRow, wrongs)
    return tableHeight

def getCellColorByPercent(percent:float, reverse:bool):
    """Возвращает цвет в зависимости от процента ошибок"""
    print('percent given {}'.format(percent))
    if reverse:
        if percent == 0:
            return '00FF00'
        red = hex(round(255*percent)).split('x')[-1]
        green = hex(round(255*(1-percent))).split('x')[-1]
        return "{}{}00".format(green, red)
    else:
        if percent == 0:
            return '00FF00'
        red = hex(round(255*percent)).split('x')[-1]
        green = hex(round(255*(1-percent))).split('x')[-1]
        return "{}{}00".format(red, green)
#-----------------------

argms = sys.argv

dbConn = mysql.connector.connect(
        host = argms[1],
        user = argms[2],
        password = argms[3],
        database = argms[4]
        )

workBook = xlsxwriter.Workbook('result.xlsx')
workSheet = workBook.add_worksheet()

headerNames = { #Словарь для названий колонн
        "test_id": "Идентификатор Теста",
        "student_id" : "Идентификатор Учащегося",
        "date" : "Дата",
        "name": "ФИО",
        "class" : "Класс",
        "date": "Дата",
        "module_name": "Название модуля",
        "percent_correct": "Процент правильных"
        }

#-----------------------

sql = argms[5]

cursor = dbConn.cursor()
cursor.execute(sql)
result = cursor.fetchall()

studentsUnsorted = []

for line in result:
    student = {} 
    student['test_id'] = line[0]
    #student['student_id'] = line[1]
    student['name'] = line[2]
    student['class'] = line[3]
    student['date'] = line[4].strftime("%Y-%m-%d")
    student['module_name'] = line[5]

    sql = "SELECT * FROM tr_{}".format(student['test_id'])
    cursor.execute(sql)
    test_result = cursor.fetchall()

    questQuantity = 0
    wrongAnswers = 0

    for question in test_result:
            student['test_num_{}'.format(question[0])] = question[0]
            student['test_var_{}'.format(question[0])] = question[1]
            student['{}'.format(question[0])] = question[5]
            if question[5] == 0:
                wrongAnswers+=1

    student['wrong_answers'] = wrongAnswers
    student['percent_correct'] = line[6]
    studentsUnsorted.append(student)

lastIndex = writeTable(workSheet, studentsUnsorted, 1, 0, True)
writeTable(workSheet, sorted(studentsUnsorted, key=itemgetter('wrong_answers')), lastIndex+3, 0, False)
workBook.close()

