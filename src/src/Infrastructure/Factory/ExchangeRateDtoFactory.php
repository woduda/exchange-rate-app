<?php

declare(strict_types=1);

namespace Infrastructure\Factory;

use Domain\ExchangeRate\Dto\ExchangeRateDto;
use Infrastructure\Shared\Persistence\Doctrine\Entity\ExchangeRate;

class ExchangeRateDtoFactory
{
    public static function createFromEntity(ExchangeRate $exchangeRate): ExchangeRateDto
    {
        return new ExchangeRateDto(
            (string)$exchangeRate->getName(),
            (string)$exchangeRate->getCode(),
            (string)$exchangeRate->getRate(),
            $exchangeRate->getDate()->format('Y-m-d')
        );
    }
}
