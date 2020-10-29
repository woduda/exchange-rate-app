<?php

declare(strict_types=1);

namespace App\Tests\Domain\ExchangeRate\Service;

use Domain\ExchangeRate\Dto\ExchangeConvertDto;
use Domain\ExchangeRate\Dto\ExchangeRateDto;
use Domain\ExchangeRate\Dto\ExchangeResultDto;
use Domain\ExchangeRate\Exception\ExchangeDateMustNotBeInFutureException;
use Domain\ExchangeRate\Exception\InvalidCurrencySelectedException;
use Domain\ExchangeRate\Repository\ExchangeRateRepository;
use Domain\ExchangeRate\Service\ExchangeRateProviderService;
use Domain\ExchangeRate\Service\ExchangeRateService;
use Domain\Shared\Contract\RuleService;
use Domain\Shared\Service\MathService;
use PHPUnit\Framework\TestCase;
use DateTimeImmutable;

class ExchangeRateServiceTest extends TestCase
{
    /** @dataProvider provide */
    public function testThatOneCurrencyCanBeConvertedToAnotherOne(
        string $currencyCodeFrom,
        string $currencyRateFrom,
        string $currencyCodeTo,
        string $currencyRateTo,
        string $amount,
        DateTimeImmutable $date,
        string $expectedResult
    ): void {
        $service = $this->createService(
            $currencyCodeFrom,
            $currencyRateFrom,
            $currencyCodeTo,
            $currencyRateTo,
            $date
        );
        $exchangeConvertDto = new ExchangeConvertDto(
            $amount,
            $currencyCodeFrom,
            $currencyCodeTo,
            $date
        );

        $result = $service->convert($exchangeConvertDto);

        $this->assertInstanceOf(ExchangeResultDto::class, $result);
        $this->assertEquals($expectedResult, (string)$result->getAmountConverted());
    }

    public function testExceptionWillBeThrownIfExchangeRateIsNotAvailable(): void
    {
        $service = $this->createService();
        $this->expectException(InvalidCurrencySelectedException::class);
        $exchangeRateDto = new ExchangeConvertDto(
            '200.60',
            'USD',
            'EUR',
            new DateTimeImmutable()
        );;
        $service->convert($exchangeRateDto);
    }

    public function testExceptionWillBeThrownIfExchangeDateIsInFuture(): void
    {
        $service = $this->createService();
        $this->expectException(ExchangeDateMustNotBeInFutureException::class);
        $exchangeRateDto = new ExchangeConvertDto(
            '200.60',
            'USD',
            'EUR',
            (new DateTimeImmutable())->modify('+1 day')
        );
        $service->convert($exchangeRateDto);
    }

    public function provide(): array
    {
        return [
            ['EUR', '4', 'USD', '3', '100', new DateTimeImmutable(), '133.33333333'],
            ['USD', '3', 'EUR', '4', '100', new DateTimeImmutable(), '75.00000000'],
            ['USD', '3.52', 'EUR', '4.67', '100', new DateTimeImmutable(), '75.37473233']
        ];
    }

    private function createService(
        ?string $currencyCodeFrom = null,
        ?string $currencyRateFrom = null,
        ?string $currencyCodeTo = null,
        ?string $currencyRateTo = null,
        ?DateTimeImmutable $date  = null
    ): ExchangeRateService {
        $ruleServiceMock = $this->getMockBuilder(RuleService::class)->getMock();
        $exchangeRateProviderServiceMock = $this
            ->getMockBuilder(ExchangeRateProviderService::class)
            ->getMock();
        $exchangeRateRepositoryMock = $this->getMockBuilder(ExchangeRateRepository::class)->getMock();

        if ($currencyCodeFrom && $currencyCodeTo) {
            $exchangeRateRepositoryMock->method('findOne')->willReturnOnConsecutiveCalls(
                new ExchangeRateDto(
                    'from',
                    $currencyCodeFrom,
                    $currencyRateFrom,
                    $date->format('Y-m-d')
                ),
                new ExchangeRateDto(
                    'to',
                    $currencyCodeTo,
                    $currencyRateTo,
                    $date->format('Y-m-d')
                )
            );
        }

        return new ExchangeRateService(
            $ruleServiceMock,
            $exchangeRateProviderServiceMock,
            $exchangeRateRepositoryMock,
            new MathService()
        );
    }
}
