<?php

/** @var yii\web\View $this
 * @var object $model
 */

?>
<div class="task-card">
    <div class="header-task">
        <a href="#" class="link link--block link--big">
            <?= $task->title ?></a>
        <p class="price price--task">
            <?= $task->budget ?> ₽</p>
    </div>
    <p class="info-text">
        <span class="current-time">
            <?= Yii::$app->formatter->asRelativeTime($task->created_at) ?>
        </span>
    </p>
    <p class="task-text">
        <?= $task->description ?>
    </p>
    <div class="footer-task">
        <?php if (isset($task->city)): ?>
        <p class="info-text town-text">
            <?= $task->city->name ?>
        </p>
        <?php endif; ?>
        <p class="info-text category-text">
            <?= $task->category->name ?>
        </p>
        <a href="#" class="button button--black">Смотреть Задание</a>
    </div>
</div>