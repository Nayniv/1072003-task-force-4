<?php

include_once __DIR__ ."/classes/Task.php";

// Создание обработчика
function my_assert_handler($file, $line, $code)
{
    echo "<hr>Неудачная проверка утверждения:
        Файл '$file'<br />
        Строка '$line'<br />
        Код '$code'<br /><hr />";
}

// Подключение callback-функции
assert_options(ASSERT_CALLBACK, 'my_assert_handler');

// пример неудачного теста - скрипт выдаст информацию о том, какой тест провалился
$t1 = new Task(1, 2);
assert($t1->getUpdateStatus(Task::ACTION_CANCEL) === Task::STATUS_CANCEL);
assert($t1->getUpdateStatus(Task::ACTION_REPLY) === Task::STATUS_WORK);

assert(in_array(Task::ACTION_CANCEL, $t1->getAvailableActions(1, Task::STATUS_NEW)));
assert(in_array(Task::ACTION_REFUSE, $t1->getAvailableActions(2, Task::STATUS_WORK)));
