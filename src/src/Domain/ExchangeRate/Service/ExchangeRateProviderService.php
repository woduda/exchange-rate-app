<?php

declare(strict_types=1);

namespace Domain\ExchangeRate\Service;

use Domain\ExchangeRate\Dto\ExchangeRateCollectionDto;
use DateTime;

interface ExchangeRateProviderService
{
    public function fetch(\DateTime $dateTime): ExchangeRateCollectionDto;
}
