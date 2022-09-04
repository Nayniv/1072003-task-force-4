<?php
namespace taskForce\businessLogic;

abstract class AbsractAction
{
    protected string $name;
    protected string $internalName;

    public function getName(): string
    {
        return $this->name;
    }

    public function getInternalName(): string
    {
        return $this->internalName;
    }

    abstract public function compareUserRole(int $executorId, int $customerId, int $currentUserId): bool
}
