import xlsxwriter
import sys
import mysql.connector
from operator import itemgetter
from xlsxwriter import utility
from datetime import datetime
import json
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
    roundedCompletionPercent = 0;
    answersAmount = {'Correct': 0, 'Wrong': 0}

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
        if len(student) < 6:
            continue
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
                    answersAmount['Correct'] += 1
                else:
                    sheet.write(row, column, student[attr], workBook.add_format({'bg_color':'#DD0000'}))
                    answersAmount['Wrong'] += 1
                
            else: 
                if '%' in str(student[attr]):
                    percent = int(student[attr].split('%')[0])/100
                    roundedCompletionPercent+=percent
                    sheet.write(row, column, student[attr], workBook.add_format({'bg_color': getCellColorByPercent(percent, True)}))
                else: 
                    sheet.write(row, column, student[attr])

            column += 1
        row += 1 
        column = startColumn


    for stat in wrongs: #Пройтись по неправильным вопросам и записать
        sheet.write(startRow+tableHeight, wrongs[stat]['col'], wrongs[stat]['val'])
        sheet.write(startRow+tableHeight+1, wrongs[stat]['col'], wrongs[stat]['val']/tableHeight*100, workBook.add_format({'bg_color': getCellColorByPercent(wrongs[stat]['val']/tableHeight, False)}))

    roundedCompletionPercent = roundedCompletionPercent/(len(students)/100)
    sheet.write(startRow+tableHeight+2, startColumn, 'Общий процент завершения: {}'.format(round(roundedCompletionPercent)))
    sheet.write(startRow+tableHeight+3, startColumn, 'Количество учеников, сдавших тест: {} '.format(len(students)))
    sheet.write(startRow+tableHeight+4, startColumn, 'Правильные ответы: {}'.format(answersAmount['Correct']))
    sheet.write(startRow+tableHeight+5, startColumn, 'Неправильные ответы: {} '.format(answersAmount['Wrong']))

    tableHeight+=6

    print(columnsToCheck, tableHeight, startRow, wrongs)

    return tableHeight, wrongs


def getCellColorByPercent(percent:float, reverse:bool):
    """Возвращает цвет в зависимости от процента ошибок"""
    print('percent given {}'.format(percent))
    if reverse:
        if percent == 0.0:
            return 'FF0-00'
        if percent == 1.0:
            return '00FF00'

        red = hex(round(255*percent)).split('x')[-1]
        green = hex(round(255*(1-percent))).split('x')[-1]
        return "{}{}00".format(green, red)
    else:
        if percent == 0.0:
            return 'FF0000'
        if percent == 1.0:
            return '00FF00'

        red = hex(round(255*percent)).split('x')[-1]
        green = hex(round(255*(1-percent))).split('x')[-1]
        return "{}{}00".format(red, green)
#-----------------------
print('#----------------')
argms = sys.argv

dbConn = mysql.connector.connect(
        host = argms[1],
        user = argms[2],
        password = argms[3],
        database = argms[4]
        )

now = datetime.now()
workBook = xlsxwriter.Workbook('{}.xlsx'.format(now.strftime("%d-%m-%Y_%H:%M:%S")))
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

studentStat = {}

answere =  {
            '4':{
                '1': {  },
                '2': {  },
                '3': {  },
                '4': {  },
                '5': {  }

            },
            '8':{
                '1': {  },
                '2': {  },
                '3': {  },
                '4': {  },
                '5': {  }
           }
    }

print(answere)

for line in result:
    student = {} 
    student['test_id'] = line[0]
    #student['student_id'] = line[1]
    student['name'] = line[1]
    student['class'] = line[2]
    student['date'] = line[3].strftime("%Y-%m-%d")
    student['module_name'] = line[4]

    sql = "SELECT * FROM tr_{}".format(student['test_id'])
    cursor.execute(sql)
    test_result = cursor.fetchall()

    questQuantity = 0
    wrongAnswers = 0

    
    for question in test_result:
            student['test_num_{}'.format(question[0])] = question[0]
            student['test_var_{}'.format(question[0])] = question[1]
            student['{}'.format(question[0])] = question[5]
            if(question[0] == 4):
                if str(question[1]) in answere['4']:
                    if str(question[3]) in answere['4'][str(question[1])]:
                        answere['4'][str(question[1])][str(question[3])] += 1
                    else:
                        answere['4'][str(question[1])][str(question[3])] = 0 
            


            if(question[0] == 8):
                if str(question[1]) in answere['8']:
                    if str(question[3]) in answere['8'][str(question[1])]:
                        answere['8'][str(question[1])][str(question[3])] += 1
                    else:
                        answere['8'][str(question[1])][str(question[3])] = 0 
            



    student['wrong_answers'] = wrongAnswers
    student['percent_correct'] = line[5]
    studentsUnsorted.append(student)

col = 0
row = 0
for answ in answere:
    for var in answere[answ]:
        for indiv in answere[answ][var]:

            workSheet.write(row, col, " {} : {} ".format(indiv, answere[answ][var][indiv]))
            
            col+=1
        row+=1
        col = 0
print(answere)

workBook.close()
print('#--------------')
