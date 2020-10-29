<?php

declare(strict_types=1);

namespace Domain\Shared\ValueObject;

use Domain\Shared\Exception\InvalidCurrencyCodeException;

class CurrencyCode implements DomainValueObject
{
    protected string $value;

    public function __construct(string $value)
    {
        if (self::isValid($value) === false) {
            throw InvalidCurrencyCodeException::create();
        }

        $this->value = $value;
    }

    public function __toString(): string
    {
        return strtoupper($this->value);
    }

    protected static function isValid(string $value): bool
    {
        return strlen($value) === 3;
    }
}
