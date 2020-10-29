<?php

declare(strict_types=1);

namespace Domain\ExchangeRate\Factory;

use DateTimeImmutable;
use Domain\ExchangeRate\Dto\ExchangeRateCollectionDto;
use Domain\ExchangeRate\Dto\ExchangeRateDto;
use Domain\Shared\Dto\DomainDto;
use Infrastructure\Shared\Persistence\Doctrine\Entity\ExchangeRate;

class ExchangeRateCollectionDtoFactory
{
    public static function createFromRawNbp(\stdClass $raw): ExchangeRateCollectionDto
    {
        $exchangeRatesCollection = new ExchangeRateCollectionDto();

        if (empty($raw) === false && empty($raw->rates) === false) {
            foreach ($raw->rates as $currency) {
                $exchangeRatesCollection->add(
                    new ExchangeRateDto(
                        (string)$currency->currency,
                        (string)$currency->code,
                        (string)$currency->mid,
                        (string)$raw->effectiveDate
                    )
                );
            }
        }

        return $exchangeRatesCollection;
    }

    public static function createFromEntities(array $entities): ExchangeRateCollectionDto
    {
        $exchangeRatesCollection = new ExchangeRateCollectionDto();

        if (empty($entities) === false) {
            foreach ($entities as $entity) {
                /** @var ExchangeRate $entity */
                $exchangeRatesCollection->add(
                    new ExchangeRateDto(
                        (string)$entity->getName(),
                        (string)$entity->getCode(),
                        (string)$entity->getRate(),
                        $entity->getDate()->format('Y-m-d')
                    )
                );
            }
        }

        return $exchangeRatesCollection;
    }

    public static function createDefaultCurrency(): ExchangeRateCollectionDto
    {
        return new ExchangeRateCollectionDto([new ExchangeRateDto(
            DomainDto::DEFAULT_CURRENCY_NAME,
            DomainDto::DEFAULT_CURRENCY_CODE,
            DomainDto::DEFAULT_CURRENCY_RATE,
            (new DateTimeImmutable())->format('Y-m-d')
        )]);
    }
}
