<?php

declare(strict_types=1);

namespace Domain\Shared\Dto;

interface Arrayable
{
    public function toArray(): array;
}
