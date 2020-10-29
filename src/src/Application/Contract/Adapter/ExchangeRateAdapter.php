<?php

declare(strict_types=1);

namespace Application\Contract\Adapter;

use Application\Command\UpdateExchangeRates\UpdateExchangeRatesCommand;
use Application\Query\ExchangeCurrencyToAnotherOne\ExchangeCurrencyToAnotherOneQuery;
use Domain\ExchangeRate\Dto\ExchangeResultDto;

interface ExchangeRateAdapter
{
    public function updateExchangeRates(UpdateExchangeRatesCommand $exchangeRatesCommand): void;
    public function convertCurrency(ExchangeCurrencyToAnotherOneQuery $currencyToAnotherOneQuery): ExchangeResultDto;
}
