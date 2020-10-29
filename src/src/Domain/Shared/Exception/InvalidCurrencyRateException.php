<?php

declare(strict_types=1);

namespace Domain\Shared\Exception;

class InvalidCurrencyRateException extends \Exception
{
    public static function create(string $message = 'Invalid rate exception!'): InvalidCurrencyRateException
    {
        return new self($message);
    }
}
