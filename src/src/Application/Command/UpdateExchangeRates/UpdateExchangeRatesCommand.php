<?php

declare(strict_types=1);

namespace Application\Command\UpdateExchangeRates;

use Application\Command;

final class UpdateExchangeRatesCommand implements Command
{
    private int $days;

    public function __construct(int $days)
    {
        $this->days = $days;
    }

    public function getDays():int
    {
        return $this->days;
    }
}
