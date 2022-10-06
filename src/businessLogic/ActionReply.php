<?php
namespace taskForce\businessLogic;

class ActionReply extends AbstractAction
{
    public function compareUserRole(int $executorId, int $customerId, int $currentUserId): bool
    {
        return $currentUserId === $executorId;
    }

    public static function getName(): string
    {
        return "Откликнуться";
    }
}
