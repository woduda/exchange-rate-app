<?php

declare(strict_types=1);

namespace Domain\ExchangeRate\Service;

use DateTimeImmutable;
use Domain\ExchangeRate\Dto\ExchangeConvertDto;
use Domain\ExchangeRate\Dto\ExchangeRateDto;
use Domain\ExchangeRate\Dto\ExchangeRateUpdateDto;
use Domain\ExchangeRate\Dto\ExchangeResultDto;
use Domain\ExchangeRate\Exception\ExchangeDateMustNotBeInFutureException;
use Domain\ExchangeRate\Exception\InvalidCurrencySelectedException;
use Domain\ExchangeRate\Factory\ExchangeRateCollectionDtoFactory;
use Domain\ExchangeRate\Port\ExchangeRatePort;
use Domain\ExchangeRate\Repository\ExchangeRateRepository;
use Domain\Shared\Contract\MathService;
use Domain\Shared\Contract\RuleService;

class ExchangeRateService implements ExchangeRatePort
{
    protected RuleService $ruleService;
    protected ExchangeRateProviderService $exchangeRateProviderService;
    protected ExchangeRateRepository $exchangeRateRepository;
    protected MathService $mathService;

    public function __construct(
        RuleService $ruleService,
        ExchangeRateProviderService $exchangeRateProviderService,
        ExchangeRateRepository $exchangeRateRepository,
        MathService $mathService
    ) {
        $this->ruleService = $ruleService;
        $this->exchangeRateProviderService = $exchangeRateProviderService;
        $this->exchangeRateRepository = $exchangeRateRepository;
        $this->mathService = $mathService;
    }

    public function update(ExchangeRateUpdateDto $exchangeRateUpdateDto): void
    {
        $this->ruleService->validate($exchangeRateUpdateDto);
        $days = $exchangeRateUpdateDto->getDaysInPast();

        for($i = 0; $i < $days; $i++) {
            $forDay = (new \DateTime())->modify(sprintf('-%s day', $i));
            $this->exchangeRateRepository->createFromCollection($this->exchangeRateProviderService->fetch($forDay));
        }

        $this->exchangeRateRepository->createFromCollection(ExchangeRateCollectionDtoFactory::createDefaultCurrency());
    }

    public function convert(ExchangeConvertDto $exchangeConvertDto): ExchangeResultDto
    {
        $now =  new DateTimeImmutable();

        if ($exchangeConvertDto->getDate()->getTimestamp() > $now->getTimestamp()) {
            throw ExchangeDateMustNotBeInFutureException::create();
        }

        $from = $this->exchangeRateRepository->findOne(
            $exchangeConvertDto->getCurrencyCodeFrom(),
            $exchangeConvertDto->getDate()
        );
        $to = $this->exchangeRateRepository->findOne(
            $exchangeConvertDto->getCurrencyCodeTo(),
            $exchangeConvertDto->getDate()
        );

        if ($from instanceof ExchangeRateDto && $to instanceof ExchangeRateDto) {
            return new ExchangeResultDto(
                (string)$exchangeConvertDto->getAmount(),
                $this->mathService->divide(
                    $this->mathService->multiply((string)$exchangeConvertDto->getAmount(), (string)$from->getCurrencyRate()),
                    (string)$to->getCurrencyRate()
                ),
                (string)$exchangeConvertDto->getCurrencyCodeFrom(),
                (string)$exchangeConvertDto->getCurrencyCodeTo(),
                $from->getCurrencyDate()
            );
        }

        throw InvalidCurrencySelectedException::create();
    }
}
