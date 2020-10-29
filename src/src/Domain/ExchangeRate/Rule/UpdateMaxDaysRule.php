<?php

declare(strict_types=1);

namespace Domain\ExchangeRate\Rule;

use Domain\ExchangeRate\Dto\ExchangeRateUpdateDto;
use Domain\ExchangeRate\Exception\DaysInPastExceededException;
use Domain\Shared\Dto\DomainDto;
use Domain\Shared\Rule\Rule;

class UpdateMaxDaysRule implements Rule
{
    protected const MAX_DAYS = 90;

    public function validate(DomainDto $domainDto): void
    {
        /** @var ExchangeRateUpdateDto $domainDto */
        $domainDto->getDaysInPast();

        if (self::MAX_DAYS < $domainDto->getDaysInPast()) {
            throw DaysInPastExceededException::create();
        }
    }
}
