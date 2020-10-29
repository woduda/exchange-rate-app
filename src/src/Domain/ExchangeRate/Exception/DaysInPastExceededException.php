<?php

declare(strict_types=1);

namespace Domain\ExchangeRate\Exception;

class DaysInPastExceededException extends \Exception
{
    public static function create(string $message = 'Maximum days in past to update exceeded!'): DaysInPastExceededException
    {
        return new self($message);
    }
}
