<?php
namespace taskForce\businessLogic;

abstract class AbstractAction
{
    abstract public static function getName(): string;

    abstract public function compareUserRole(int $executorId, int $customerId, int $currentUserId): bool;
}
