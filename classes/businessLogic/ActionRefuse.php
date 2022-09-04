<?php
namespace taskForce\businessLogic;

class ActionRefuse extends AbstractAction
{
    protected string $name = "Отказаться";
    protected string $internalName = "refuse";

    public function compareUserRole(int $executorId, int $customerId, int $currentUserId): bool
    {
        return $currentUserId === $executorId;
    }
}
