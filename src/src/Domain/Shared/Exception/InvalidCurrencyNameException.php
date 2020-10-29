<?php

declare(strict_types=1);

namespace Domain\Shared\Exception;

class InvalidCurrencyNameException extends \Exception
{
    public static function create(string $message = 'Invalid currency name exception!'): InvalidCurrencyNameException
    {
        return new self($message);
    }
}
