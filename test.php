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
assert($t1->getUpdateStatus(new ActionCancel()) === Task::STATUS_CANCEL);
assert($t1->getUpdateStatus(new ActionReply()) === Task::STATUS_WORK);

assert(in_array(new ActionCancel(), $t1->getAvailableActions(1, Task::STATUS_NEW)));
assert(in_array(new ActionRefuse(), $t1->getAvailableActions(2, Task::STATUS_WORK)));
assert(in_array(new ActionReply(), $t1->getAvailableActions(2, Task::STATUS_WORK)));
assert(in_array(new ActionDone(), $t1->getAvailableActions(2, Task::STATUS_WORK)));
assert(in_array(new ActionRefuse(), $t1->getAvailableActions(1, Task::STATUS_NEW)));
