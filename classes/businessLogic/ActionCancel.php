<?php
namespace taskForce\businessLogic;

class ActionCancel extends AbstractAction
{
    public function compareUserRole(int $executorId, int $customerId, int $currentUserId): bool
    {
        return $currentUserId === $customerId;
    }

    public static function getName(): string
    {
        return "Отменить";
    }
}
