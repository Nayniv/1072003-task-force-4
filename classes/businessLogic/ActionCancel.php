<?php
namespace taskForce\businessLogic;

class ActionCancel extends AbstractAction
{
    protected string $name = "Отменить";
    protected string $internalName = "cancel";

    public function compareUserRole(int $executorId, int $customerId, int $currentUserId): bool
    {
        return $currentUserId === $customerId;
    }
}
