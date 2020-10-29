<?php

declare(strict_types=1);

namespace Domain\Shared\Contract;

use Domain\Shared\ValueObject\Amount;

interface MathService
{
    public function multiply(string $left, string $right): string;
    public function divide(string $left, string $right): string;
}
