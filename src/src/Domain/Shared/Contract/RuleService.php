<?php

declare(strict_types=1);

namespace Domain\Shared\Contract;

use Domain\Shared\Dto\DomainDto;

interface RuleService
{
    public function validate(DomainDto $domainDto): void;
}
