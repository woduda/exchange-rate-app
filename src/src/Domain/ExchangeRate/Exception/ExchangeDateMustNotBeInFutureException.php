<?php

declare(strict_types=1);

namespace Domain\ExchangeRate\Exception;

class ExchangeDateMustNotBeInFutureException extends \Exception
{
    public static function create(
        string $message = 'Exchange rate date must be not be in future exception!'
    ) : ExchangeDateMustNotBeInFutureException {
        return new self($message);
    }
}
