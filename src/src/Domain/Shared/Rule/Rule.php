<?php

declare(strict_types=1);

namespace Domain\Shared\Rule;

use Domain\Shared\Dto\DomainDto;
use Domain\Shared\Exception\InvalidRuleException;

interface Rule
{
    /**
     * @throws InvalidRuleException
     */
    public function validate(DomainDto $domainDto): void;
}
