# webasyst-dirr

## Описание скрипта

Скрипт используется для поиска удаленных файлов

## Описание работы

Скрипт берет конфиг из файла /conf.php. Конфиг представляет из себя ассоциативный массив, где:
- from - исходный проект
- to - проект, в котором ищем удаленные файлы
- ignoredDir - массив игнорируемых дирректорий
- ignoredFiles - массив игнорируемых файлов

На выходе в консоле получаем массив с удаленными файлами и дирректориями