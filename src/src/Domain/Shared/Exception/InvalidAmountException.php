<?php

declare(strict_types=1);

namespace Domain\Shared\Exception;

class InvalidAmountException extends \Exception
{
    public static function create(string $message = 'Invalid amount exception!'): InvalidAmountException
    {
        return new self($message);
    }
}
