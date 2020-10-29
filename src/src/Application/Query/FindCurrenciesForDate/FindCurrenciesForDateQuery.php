<?php

declare(strict_types=1);

namespace Application\Query\FindCurrenciesForDate;

use Application\Query;
use DateTimeImmutable;

final class FindCurrenciesForDateQuery implements Query
{
    private DateTimeImmutable $date;

    public function __construct(DateTimeImmutable $date)
    {
        $this->date = $date;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }
}
