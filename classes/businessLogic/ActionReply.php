<?php
namespace taskForce\businessLogic;

class ActionReply extends AbstractAction
{
    protected string $name = "Откликнуться";

    public function compareUserRole(int $executorId, int $customerId, int $currentUserId): bool
    {
        return $currentUserId === $executorId;
    }
}
