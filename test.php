<?php
require_once 'vendor/autoload.php';

use taskForce\businessLogic\Task;

function my_assert_handler($file, $line, $code)
{
    echo "<hr>Неудачная проверка утверждения:
        Файл '$file'<br />
        Строка '$line'<br />
        Код '$code'<br /><hr />";
}

assert_options(ASSERT_CALLBACK, 'my_assert_handler');

$t1 = new Task(1, 2);
assert($t1->getUpdateStatus(ActionCancel::class) === Task::STATUS_CANCEL);
assert($t1->getUpdateStatus(ActionReply::class) === Task::STATUS_WORK);

assert(in_array(ActionCancel::class, $t1->getAvailableActions(1, Task::STATUS_NEW)));
assert(in_array(ActionRefuse::class, $t1->getAvailableActions(2, Task::STATUS_WORK)));
assert(in_array(ActionReply::class, $t1->getAvailableActions(2, Task::STATUS_WORK)));
assert(in_array(ActionDone::class, $t1->getAvailableActions(2, Task::STATUS_WORK)));
assert(in_array(ActionRefuse::class, $t1->getAvailableActions(1, Task::STATUS_NEW)));
