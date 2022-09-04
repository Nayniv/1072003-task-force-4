<?php
namespace taskForce\businessLogic;

use ActionCancel;
use ActionReply;
use ActionDone;
use ActionRefuse;

class Task
{
    public const STATUS_NEW = 'new';
    public const STATUS_CANCEL = 'cancel';
    public const STATUS_WORK = 'work';
    public const STATUS_DONE = 'done';
    public const STATUS_FAIL = 'fail';

    public const ACTION_CANCEL = 'cancel';
    public const ACTION_REPLY = 'reply';
    public const ACTION_DONE = 'done';
    public const ACTION_REFUSE = 'refuse';

    private const UPDATE_STATUS = [
        self::ACTION_CANCEL => self::STATUS_CANCEL,
        self::ACTION_REPLY => self::STATUS_WORK,
        self::ACTION_DONE => self::STATUS_DONE,
        self::ACTION_REFUSE => self::STATUS_FAIL
    ];

    private $customerId;
    private $executorId;

    public function __construct(int $customerId, int $executorId = null)
    {
        $this->customerId = $customerId;
        $this->executorId = $executorId;
    }

    //public function getCustomerId {}
    //public function getExecutorId {}

    public function getStatusesTitles(): array
    {
        return [
            self::STATUS_NEW=> 'Новое',
            self::STATUS_CANCEL=> 'Отменено',
            self::STATUS_WORK=> 'В работе',
            self::STATUS_DONE=> 'Выполнено',
            self::STATUS_FAIL=> 'Провалено',
        ];
    }

    public function getActionsTitles(): array
    {
        return [
            self::ACTION_CANCEL=> 'Отменить',
            self::ACTION_REPLY=> 'Откликнуться',
            self::ACTION_DONE=> 'Выполнено',
            self::ACTION_REFUSE=> 'Отказаться',
        ];
    }

    public function getUpdateStatus(string $action): string
    {
        return self::UPDATE_STATUS[$action];
    }

    public function getAvailableActions(int $currentUserId, string $status): array
    {
        $actions = [];

        if ((new ActionCancel())->compareUserRole($this->executorId, $this->customerId, $currentUserId) && $status === self::STATUS_NEW) {
            $actions[] = new ActionCancel();
        }
        if ((new ActionDone())->compareUserRole($this->executorId, $this->customerId, $currentUserId) && $status === self::STATUS_WORK) {
            $actions[] = new ActionDone();
        }

        if ((new ActionReply())->compareUserRole($this->executorId, $this->customerId, $currentUserId) && $status === self::STATUS_NEW) {
            $actions[] = new ActionReply();
        }
        if ((new ActionRefuse())->compareUserRole($this->executorId, $this->customerId, $currentUserId) && $status === self::STATUS_WORK) {
            $actions[] = new ActionRefuse();
        }

        return $actions;
    }
}
