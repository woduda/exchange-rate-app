<?php

declare(strict_types=1);

namespace Domain\ExchangeRate\Repository;

use Domain\ExchangeRate\Dto\ExchangeCurrenciesDto;
use Domain\ExchangeRate\Dto\ExchangeRateCollectionDto;
use DateTimeImmutable;
use Domain\ExchangeRate\Dto\ExchangeRateDto;
use Domain\Shared\ValueObject\CurrencyCode;

interface ExchangeRateRepository
{
    public function createFromCollection(ExchangeRateCollectionDto $exchangeRateCollectionDto): void;
    public function getAllForDate(DateTimeImmutable $date): ExchangeRateCollectionDto;
    public function getAllCurrencyCodes(): ExchangeCurrenciesDto;
    public function findOne(CurrencyCode $currencyCode, DateTimeImmutable $currencyDate): ?ExchangeRateDto;
}
