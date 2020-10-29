<?php

declare(strict_types=1);

namespace Application\Adapter;

use Application\Command\UpdateExchangeRates\UpdateExchangeRatesCommand;
use Application\Contract\Adapter\ExchangeRateAdapter as ExchangeRateAdapterInterface;
use Application\Query\ExchangeCurrencyToAnotherOne\ExchangeCurrencyToAnotherOneQuery;
use Domain\ExchangeRate\Dto\ExchangeConvertDto;
use Domain\ExchangeRate\Dto\ExchangeRateUpdateDto;
use Domain\ExchangeRate\Dto\ExchangeResultDto;
use Domain\ExchangeRate\Port\ExchangeRatePort;

class ExchangeRateAdapter implements ExchangeRateAdapterInterface
{
    protected ExchangeRatePort $exchangeRatePort;

    public function __construct(ExchangeRatePort $exchangeRatePort)
    {
        $this->exchangeRatePort = $exchangeRatePort;
    }

    public function updateExchangeRates(UpdateExchangeRatesCommand $exchangeRatesCommand): void
    {
        $this->exchangeRatePort->update(new ExchangeRateUpdateDto($exchangeRatesCommand->getDays()));
    }

    public function convertCurrency(ExchangeCurrencyToAnotherOneQuery $currencyToAnotherOneQuery): ExchangeResultDto
    {
        return $this->exchangeRatePort->convert(
            new ExchangeConvertDto(
                $currencyToAnotherOneQuery->getAmount(),
                $currencyToAnotherOneQuery->getFrom(),
                $currencyToAnotherOneQuery->getTo(),
                $currencyToAnotherOneQuery->getDate()
            )
        );
    }
}
