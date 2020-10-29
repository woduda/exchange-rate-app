<?php

declare(strict_types=1);

namespace Domain\ExchangeRate\Exception;

class ExternalSourceUnreachableException extends \Exception
{
    public static function create(string $message = 'External source of currency rates is unreachable!'): ExternalSourceUnreachableException
    {
        return new self($message);
    }
}
