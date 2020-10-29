<?php

declare(strict_types=1);

namespace Application\Query\ExchangeCurrencyToAnotherOne;

use Application\Query;
use DateTimeImmutable;

final class ExchangeCurrencyToAnotherOneQuery implements Query
{
    private string $amount;
    private string $from;
    private string $to;
    private DateTimeImmutable $date;

    public function __construct(string $amount, string $from, string $to, DateTimeImmutable $date)
    {
        $this->amount = $amount;
        $this->from = $from;
        $this->to = $to;
        $this->date = $date;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getTo(): string
    {
        return $this->to;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }
}
