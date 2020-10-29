<?php

declare(strict_types=1);

namespace Domain\Shared\Service;

use Domain\Shared\Contract\MathService as MathServiceInterface;

class MathService implements MathServiceInterface
{
    protected const SCALE = 8;
    protected const ZERO = '0';

    public function multiply(string $left, string $right): string
    {
        try {
            return bcmul($left, $right, self::SCALE);
        } catch (\Throwable $exception) {
            return self::ZERO;
        }
    }

    public function divide(string $left, string $right): string
    {
        try {
            return bcdiv($left, $right, self::SCALE);
        } catch (\Throwable $exception) {
            return self::ZERO;
        }
    }
}
