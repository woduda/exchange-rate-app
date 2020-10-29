<?php

declare(strict_types=1);

namespace Domain\ExchangeRate\Port;

use Domain\ExchangeRate\Dto\ExchangeConvertDto;
use Domain\ExchangeRate\Dto\ExchangeRateUpdateDto;
use Domain\ExchangeRate\Dto\ExchangeResultDto;

interface ExchangeRatePort
{
    public function update(ExchangeRateUpdateDto $exchangeRateUpdateDto): void;
    public function convert(ExchangeConvertDto $exchangeConvertDto): ExchangeResultDto;
}
