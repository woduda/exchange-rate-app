<?php

declare(strict_types=1);

namespace Domain\Shared\Exception;

class InvalidRuleException extends \Exception
{
    public static function create(string $message = 'Invalid rule exception!'): InvalidRuleException
    {
        return new self($message);
    }
}
