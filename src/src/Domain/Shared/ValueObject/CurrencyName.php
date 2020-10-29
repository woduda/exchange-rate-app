<?php

declare(strict_types=1);

namespace Domain\Shared\ValueObject;

use Domain\Shared\Exception\InvalidCurrencyNameException;

class CurrencyName implements DomainValueObject
{
    protected string $value;

    public function __construct(string $value)
    {
        if (self::isValid($value) === false) {
            throw InvalidCurrencyNameException::create();
        }

        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    protected static function isValid(string $value): bool
    {
        return strlen($value) > 1 && strlen($value) <= 255;
    }
}
