<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Persistence\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Domain\Shared\ValueObject\CurrencyCode;

class CurrencyCodeType extends StringType
{
    protected const CURRENCY_CODE = 'currency_code';

    public function getName()
    {
        return self::CURRENCY_CODE;
    }

    public function convertToPhpValue($value, AbstractPlatform $platform)
    {
        return new CurrencyCode($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (string)$value;
    }
}
