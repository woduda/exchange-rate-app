<?php

declare(strict_types=1);

namespace Domain\Shared\Exception;

class InvalidCurrencyCodeException extends \Exception
{
    public static function create(string $message = 'Invalid currency code exception!'): InvalidCurrencyCodeException
    {
        return new self($message);
    }
}
