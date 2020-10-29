<?php

declare(strict_types=1);

namespace Application\Command\UpdateExchangeRates;

use Application\CommandHandler;
use Application\Contract\Adapter\ExchangeRateAdapter;

final class UpdateExchangeRatesHandler implements CommandHandler
{
    protected ExchangeRateAdapter $exchangeRateAdapter;

    public function __construct(ExchangeRateAdapter $exchangeRateAdapter)
    {
        $this->exchangeRateAdapter = $exchangeRateAdapter;
    }

    public function __invoke(UpdateExchangeRatesCommand $command): void
    {
        $this->exchangeRateAdapter->updateExchangeRates($command);
    }
}
