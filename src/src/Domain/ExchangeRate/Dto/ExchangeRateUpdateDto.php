<?php

declare(strict_types=1);

namespace Domain\ExchangeRate\Dto;

use Domain\Shared\Dto\DomainDto;

class ExchangeRateUpdateDto implements DomainDto
{
    protected int $daysInPast;

    public function __construct(int $daysInPast)
    {
        $this->daysInPast = $daysInPast;
    }

    public function getDaysInPast(): int
    {
        return $this->daysInPast;
    }
}
