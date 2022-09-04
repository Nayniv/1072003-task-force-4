<?php
namespace taskForce\businessLogic;

class ActionDone extends AbstractAction
{
    protected string $name = "Выполнено";
    protected string $internalName = "done";

    public function compareUserRole(int $executorId, int $customerId, int $currentUserId): bool
    {
        return $currentUserId === $customerId;
    }
}
