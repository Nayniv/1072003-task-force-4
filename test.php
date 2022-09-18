<?php
declare(strict_types=1);

ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once 'vendor/autoload.php';

use taskForce\businessLogic\Task;
use taskForce\businessLogic\ActionCancel;
use taskForce\businessLogic\ActionReply;
use taskForce\businessLogic\ActionDone;
use taskForce\businessLogic\ActionRefuse;
use taskForce\businessLogic\Exceptions\ActionException;
use taskForce\businessLogic\Exceptions\StatusException;

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

assert(in_array(ActionCancel::class, $t1->getAvailableActions(1, Task::STATUS_NEW)));
assert(in_array(ActionRefuse::class, $t1->getAvailableActions(2, Task::STATUS_WORK)));
assert(in_array(ActionReply::class, $t1->getAvailableActions(2, Task::STATUS_NEW)));
assert(in_array(ActionDone::class, $t1->getAvailableActions(1, Task::STATUS_WORK)));
assert(in_array(ActionRefuse::class, $t1->getAvailableActions(2, Task::STATUS_WORK)));

try {
    $t1->getUpdateStatus(new ActionCancel());
} catch (ActionException $e) {
    die($e->getMessage());
};
