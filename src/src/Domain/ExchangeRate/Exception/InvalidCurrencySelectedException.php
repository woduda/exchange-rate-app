<?php

declare(strict_types=1);

namespace Domain\ExchangeRate\Exception;

class InvalidCurrencySelectedException extends \Exception
{
    public static function create(
        string $message = 'Invalid currency selected exception'
    ): InvalidCurrencySelectedException {
        return new self($message);
    }
}
