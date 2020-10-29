<?php

declare(strict_types=1);

namespace Application\Query\ExchangeCurrencyToAnotherOne;

use Application\Contract\Adapter\ExchangeRateAdapter;
use Application\QueryHandler;
use Domain\ExchangeRate\Dto\ExchangeResultDto;

final class ExchangeCurrencyToAnotherOneHandler implements QueryHandler
{
    private ExchangeRateAdapter $exchangeRateAdapter;

    public function __construct(ExchangeRateAdapter $exchangeRateAdapter)
    {
        $this->exchangeRateAdapter = $exchangeRateAdapter;
    }

    public function __invoke(ExchangeCurrencyToAnotherOneQuery $currencyToAnotherOneQuery): ExchangeResultDto
    {
        return $this->exchangeRateAdapter->convertCurrency($currencyToAnotherOneQuery);
    }
}
