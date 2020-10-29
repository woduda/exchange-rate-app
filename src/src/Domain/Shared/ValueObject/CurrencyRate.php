<?php

declare(strict_types=1);

namespace Domain\Shared\ValueObject;

use Domain\Shared\Exception\InvalidCurrencyRateException;

class CurrencyRate implements DomainValueObject
{
    protected string $value;

    public function __construct(string $value)
    {
        if (self::isValid($value) === false) {
            throw InvalidCurrencyRateException::create();
        }

        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    protected static function isValid(string $value): bool
    {
        return is_numeric($value) && is_double((float)$value);
    }
}
