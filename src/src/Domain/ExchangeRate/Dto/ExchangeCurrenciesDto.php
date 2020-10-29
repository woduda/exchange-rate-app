<?php

declare(strict_types=1);

namespace Domain\ExchangeRate\Dto;

use Domain\Shared\Dto\Arrayable;
use Domain\Shared\Dto\DomainDto;
use Domain\Shared\ValueObject\CurrencyCode;

class ExchangeCurrenciesDto implements DomainDto, Arrayable
{
    /** @var array<CurrencyCode>  */
    public array $codes;

    public function __construct(array $codes)
    {
        $this->codes = $codes;
    }

    public function toArray(): array
    {
        $codes = [];

        foreach ($this->codes as $code) {
            /** @var $code CurrencyCode */
           array_push($codes, (string)$code);
        }

        return $codes;
    }
}
