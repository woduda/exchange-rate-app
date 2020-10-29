<?php

declare(strict_types=1);

namespace Application\Query\FindCurrenciesForDate;

use Application\QueryHandler;
use Domain\ExchangeRate\Dto\ExchangeRateCollectionDto;
use Infrastructure\Shared\Persistence\Doctrine\Repository\ExchangeRateRepository;

final class FindCurrenciesForDateHandler implements QueryHandler
{
    private ExchangeRateRepository $exchangeRateRepository;

    public function __construct(ExchangeRateRepository $exchangeRateRepository)
    {
        $this->exchangeRateRepository = $exchangeRateRepository;
    }

    public function __invoke(FindCurrenciesForDateQuery $findCurrenciesForDateQuery): ExchangeRateCollectionDto
    {
        return $this->exchangeRateRepository->getAllForDate($findCurrenciesForDateQuery->getDate());
    }
}
