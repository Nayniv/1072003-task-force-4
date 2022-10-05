<?php

namespace taskForce\businessLogic;

use taskForce\businessLogic\ActionCancel;
use taskForce\businessLogic\ActionReply;
use taskForce\businessLogic\ActionDone;
use taskForce\businessLogic\ActionRefuse;
use taskForce\businessLogic\Exceptions\ActionException;
use taskForce\businessLogic\Exceptions\StatusException;

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
        if (!array_key_exists(get_class($action), $this->getActionsTitles())){
            throw new ActionException();
        }

        return self::UPDATE_STATUS[get_class($action)];
    }

    public function getAvailableActions(int $currentUserId, string $status): array
    {
        $actions = [];

        if (!array_key_exists($status, $this->getStatusesTitles())){
            throw new StatusException();
        }

        if ((new ActionCancel())->compareUserRole($this->executorId, $this->customerId, $currentUserId) && ($status === self::STATUS_NEW)) {
            $actions[] = ActionCancel::class;
        }
        if ((new ActionDone())->compareUserRole($this->executorId, $this->customerId, $currentUserId) && ($status === self::STATUS_WORK)) {
            $actions[] = ActionDone::class;
        }

        if ((new ActionReply())->compareUserRole($this->executorId, $this->customerId, $currentUserId) && ($status === self::STATUS_NEW)) {
            $actions[] = ActionReply::class;
        }
        if ((new ActionRefuse())->compareUserRole($this->executorId, $this->customerId, $currentUserId) && ($status === self::STATUS_WORK)) {
            $actions[] = ActionRefuse::class;
        }

        return $actions;
    }
}
