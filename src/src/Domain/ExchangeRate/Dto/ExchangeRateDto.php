<?php

declare(strict_types=1);

namespace Domain\ExchangeRate\Dto;

use Domain\Shared\Dto\DomainDto;
use Domain\Shared\ValueObject\CurrencyCode;
use Domain\Shared\ValueObject\CurrencyName;
use Domain\Shared\ValueObject\CurrencyRate;
use DateTimeImmutable;

class ExchangeRateDto implements DomainDto
{
    protected CurrencyName $currencyName;
    protected CurrencyCode $currencyCode;
    protected CurrencyRate $currencyRate;
    protected DateTimeImmutable $currencyDate;

    public function __construct(
        string $currencyName,
        string $currencyCode,
        string $currencyRate,
        string $currencyDate
    ) {
        $this->currencyName = new CurrencyName($currencyName);
        $this->currencyCode = new CurrencyCode($currencyCode);
        $this->currencyRate = new CurrencyRate($currencyRate);
        $this->currencyDate = new DateTimeImmutable($currencyDate);
    }


    public function getCurrencyName(): CurrencyName
    {
        return $this->currencyName;
    }

    public function getCurrencyCode(): CurrencyCode
    {
        return $this->currencyCode;
    }

    public function getCurrencyRate(): CurrencyRate
    {
        return $this->currencyRate;
    }

    public function getCurrencyDate(): DateTimeImmutable
    {
        return $this->currencyDate;
    }
}
