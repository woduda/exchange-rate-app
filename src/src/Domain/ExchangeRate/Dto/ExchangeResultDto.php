<?php

declare(strict_types=1);

namespace Domain\ExchangeRate\Dto;

use Domain\Shared\Dto\DomainDto;
use Domain\Shared\ValueObject\Amount;
use DateTimeImmutable;
use Domain\Shared\ValueObject\CurrencyCode;

class ExchangeResultDto implements DomainDto
{
    private Amount $amountOriginal;
    private Amount $amountConverted;
    private CurrencyCode $currencyCodeFrom;
    private CurrencyCode $currencyCodeTo;
    private DateTimeImmutable $date;

    public function __construct(
        string $amountOriginal,
        string $amountConverted,
        string $currencyCodeFrom,
        string $currencyCodeTo,
        DateTimeImmutable $date
    ) {
        $this->amountOriginal = new Amount($amountOriginal);
        $this->amountConverted = new Amount($amountConverted);
        $this->currencyCodeFrom = new CurrencyCode($currencyCodeFrom);
        $this->currencyCodeTo = new CurrencyCode($currencyCodeTo);
        $this->date = $date;
    }

    public function getAmountOriginal(): Amount
    {
        return $this->amountOriginal;
    }

    public function getAmountConverted(): Amount
    {
        return $this->amountConverted;
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
