<?php

declare(strict_types=1);

namespace Domain\Shared\Service;

use Domain\Shared\Contract\RuleService as RuleServiceInterface;
use Domain\Shared\Dto\DomainDto;
use Domain\Shared\Rule\Rule;
use Domain\Shared\Rule\RuleCollection;

class RuleService implements RuleServiceInterface
{
    protected RuleCollection $ruleCollection;

    public function __construct(array $rules)
    {
        $this->ruleCollection = new RuleCollection($rules);
    }

    public function validate(DomainDto $domainDto): void
    {
        foreach ($this->ruleCollection as $rule) {
            /** @var Rule $rule */
            $rule->validate($domainDto);
        }
    }
}
