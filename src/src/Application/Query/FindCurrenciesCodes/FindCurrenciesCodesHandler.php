<?php

declare(strict_types=1);

namespace Application\Query\FindCurrenciesCodes;

use Application\QueryHandler;
use Domain\ExchangeRate\Dto\ExchangeCurrenciesDto;
use Infrastructure\Shared\Persistence\Doctrine\Repository\ExchangeRateRepository;

final class FindCurrenciesCodesHandler implements QueryHandler
{
    private ExchangeRateRepository $exchangeRateRepository;

    public function __construct(ExchangeRateRepository $exchangeRateRepository)
    {
        $this->exchangeRateRepository = $exchangeRateRepository;
    }

    public function __invoke(FindCurrenciesCodesQuery $findCurrenciesCodesQuery): ExchangeCurrenciesDto
    {
        return $this->exchangeRateRepository->getAllCurrencyCodes();
    }
}
