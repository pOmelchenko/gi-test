[![Build Status](https://travis-ci.org/pOmelchenko/gi-test.svg?branch=master)](https://travis-ci.org/pOmelchenko/gi-test)

# Задание
Есть текстовый файл, в который пишутся какие-то данные, построчно.
Числа, символы, буквы что угодно.  
Нужно написать скрипт, который будет запускаться из `cron`.
Скрипт должен забрать из каждой строки все числа, посчитать количество
совпадений и вывести в `STDOUT` числа и количество совпавших чисел в порядке
убывания.

Пример:
```text
3 - 15
12 - 10
4 - 3
7 - 1
```

Используются только целые и положительные числа.

# Решение
Для подсчета цифр в файле выполните одну из трех команд:
```text
get-statistic/via-array            Read file and return statistic about digits use array for that             
get-statistic/via-sqlite-in-memory Read file and return statistic about digits use sqlite in memory for that  
get-statistic/via-sqlite-in-file   Read file and return statistic about digits use sqlite in file for that.   
```
Выполнив `php bin/reader $command`, где `$command` одна из тех что перечислены выше
