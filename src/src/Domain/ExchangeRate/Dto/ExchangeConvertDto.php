<?php

declare(strict_types=1);

namespace Domain\ExchangeRate\Dto;

use Domain\Shared\Dto\DomainDto;
use Domain\Shared\ValueObject\Amount;
use DateTimeImmutable;
use Domain\Shared\ValueObject\CurrencyCode;

class ExchangeConvertDto implements DomainDto
{
    private Amount $amount;
    private CurrencyCode $currencyCodeFrom;
    private CurrencyCode $currencyCodeTo;
    private DateTimeImmutable $date;

    public function __construct(
        string $amount,
        string $currencyCodeFrom,
        string $currencyCodeTo,
        DateTimeImmutable $date
    ) {
        $this->amount = new Amount($amount);
        $this->currencyCodeFrom = new CurrencyCode($currencyCodeFrom);
        $this->currencyCodeTo = new CurrencyCode($currencyCodeTo);
        $this->date = $date;
    }

    public function getAmount(): Amount
    {
        return $this->amount;
    }

    public function getCurrencyCodeFrom(): CurrencyCode
    {
        return $this->currencyCodeFrom;
    }

    public function getCurrencyCodeTo(): CurrencyCode
    {
        return $this->currencyCodeTo;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }
}
