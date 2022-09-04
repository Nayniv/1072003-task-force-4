<?php
namespace taskForce\businessLogic;

class ActionReply extends AbstractAction
{
    protected string $name = "Откликнуться";
    protected string $internalName = "reply";

    public function compareUserRole(int $executorId, int $customerId, int $currentUserId): bool
    {
        return $currentUserId === $executorId;
    }
}
