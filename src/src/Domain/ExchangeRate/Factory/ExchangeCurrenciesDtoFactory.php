<?php

declare(strict_types=1);

namespace Domain\ExchangeRate\Factory;

use Domain\ExchangeRate\Dto\ExchangeCurrenciesDto;

class ExchangeCurrenciesDtoFactory
{
    public static function createFromRaw(array $currencies): ExchangeCurrenciesDto
    {
        foreach ($currencies as $index => $currency) {
            $currencies[$index] = $currency['code'];
        }

        return new ExchangeCurrenciesDto($currencies);
    }
}
