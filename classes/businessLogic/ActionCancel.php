<?php
namespace taskForce\businessLogic;

class ActionCancel extends AbstractAction
{
    protected string $name = "Отменить";

    public function compareUserRole(int $executorId, int $customerId, int $currentUserId): bool
    {
        return $currentUserId === $customerId;
    }
}
