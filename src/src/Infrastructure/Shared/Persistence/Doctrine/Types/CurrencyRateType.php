<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Persistence\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DecimalType;
use Domain\Shared\ValueObject\CurrencyRate;

class CurrencyRateType extends DecimalType
{
    protected const CURRENCY_RATE = 'currency_rate';

    public function getName()
    {
        return self::CURRENCY_RATE;
    }


    public function convertToPhpValue($value, AbstractPlatform $platform)
    {
        return new CurrencyRate($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (string)$value;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        $column['scale'] = 8;
        return $platform->getDecimalTypeDeclarationSQL($column);
    }
}
