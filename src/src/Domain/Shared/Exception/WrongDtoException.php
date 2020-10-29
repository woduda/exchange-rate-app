<?php

declare(strict_types=1);

namespace Domain\Shared\Exception;

class WrongDtoException extends \Exception
{
    public static function create(string $message = 'Wrong dto given exception!'): WrongDtoException
    {
        return new self($message);
    }
}
