<?php
namespace taskForce\businessLogic;

abstract class AbstractAction
{
    protected string $name;

    public static function getName(): string
    {
        return $this->name;
    }

    abstract public function compareUserRole(int $executorId, int $customerId, int $currentUserId): bool;
}
