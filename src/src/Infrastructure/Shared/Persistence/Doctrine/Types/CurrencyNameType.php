<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Persistence\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Domain\Shared\ValueObject\CurrencyName;

class CurrencyNameType extends StringType
{
    protected const CURRENCY_NAME = 'currency_name';

    public function getName()
    {
        return self::CURRENCY_NAME;
    }

    public function convertToPhpValue($value, AbstractPlatform $platform)
    {
        return new CurrencyName($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (string)$value;
    }
}
