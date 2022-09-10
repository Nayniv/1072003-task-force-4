<?php

namespace taskForce\businessLogic;

use taskForce\businessLogic\ActionCancel;
use taskForce\businessLogic\ActionReply;
use taskForce\businessLogic\ActionDone;
use taskForce\businessLogic\ActionRefuse;

class Task
{
    public const STATUS_NEW = 'new';
    public const STATUS_CANCEL = 'cancel';
    public const STATUS_WORK = 'work';
    public const STATUS_DONE = 'done';
    public const STATUS_FAIL = 'fail';

    private const UPDATE_STATUS = [
        ActionCancel::class => self::STATUS_CANCEL,
        ActionReply::class => self::STATUS_WORK,
        ActionDone::class => self::STATUS_DONE,
        ActionRefuse::class => self::STATUS_FAIL
    ];

    private $customerId;
    private $executorId;

    public function __construct(int $customerId, int $executorId = null)
    {
        $this->customerId = $customerId;
        $this->executorId = $executorId;
    }

    public function getStatusesTitles(): array
    {
        return [
            self::STATUS_NEW => 'Новое',
            self::STATUS_CANCEL => 'Отменено',
            self::STATUS_WORK => 'В работе',
            self::STATUS_DONE => 'Выполнено',
            self::STATUS_FAIL => 'Провалено',
        ];
    }

    public function getActionsTitles(): array
    {
        return [
            ActionCancel::class => ActionCancel::getName(),
            ActionReply::class => ActionReply::getName(),
            ActionDone::class => ActionDone::getName(),
            ActionRefuse::class => ActionRefuse::getName(),
        ];
    }

    public function getUpdateStatus(AbstractAction $action): string
    {
        return self::UPDATE_STATUS[get_class($action)];
    }

    public function getAvailableActions(int $currentUserId, $status): array
    {
        $actions = [];

        if ((new ActionCancel())->compareUserRole($this->executorId, $this->customerId, $currentUserId) && ($status === self::STATUS_NEW)) {
            $actions[] = new ActionCancel();
        }
        if ((new ActionDone())->compareUserRole($this->executorId, $this->customerId, $currentUserId) && ($status === self::STATUS_WORK)) {
            $actions[] = new ActionDone();
        }

        if ((new ActionReply())->compareUserRole($this->executorId, $this->customerId, $currentUserId) && ($status === self::STATUS_NEW)) {
            $actions[] = new ActionReply();
        }
        if ((new ActionRefuse())->compareUserRole($this->executorId, $this->customerId, $currentUserId) && ($status === self::STATUS_WORK)) {
            $actions[] = new ActionRefuse();
        }

        return $actions;
    }
}
