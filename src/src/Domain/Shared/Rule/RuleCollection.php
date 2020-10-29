<?php

declare(strict_types=1);

namespace Domain\Shared\Rule;

use Doctrine\Common\Collections\ArrayCollection;
use Domain\Shared\Exception\InvalidRuleException;

class RuleCollection extends ArrayCollection
{
    public function __construct(array $elements = [])
    {
        if (empty($elements) === false) {
            foreach ($elements as $index => $element) {
                $element = new $element;

                if (($element instanceof Rule) === false) {
                    throw InvalidRuleException::create();
                }

                $elements[$index] = $element;
            }
        }

        parent::__construct($elements);
    }
}
