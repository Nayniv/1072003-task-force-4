<?php
namespace taskForce\businessLogic;

class ActionRefuse extends AbstractAction
{
    protected string $name = "Отказаться";

    public function compareUserRole(int $executorId, int $customerId, int $currentUserId): bool
    {
        return $currentUserId === $executorId;
    }
}
