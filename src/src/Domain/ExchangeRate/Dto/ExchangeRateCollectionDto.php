<?php

declare(strict_types=1);

namespace Domain\ExchangeRate\Dto;

use Doctrine\Common\Collections\ArrayCollection;
use Domain\Shared\Dto\DomainDto;
use Domain\Shared\Exception\WrongDtoException;

class ExchangeRateCollectionDto extends ArrayCollection implements DomainDto
{
    public function __construct(array $elements = [])
    {
        if (empty($elements) === false) {
            foreach ($elements as $index => $element) {
                if (($element instanceof ExchangeRateDto) === false) {
                    throw WrongDtoException::create();
                }

                $elements[$index] = $element;
            }
        }
        parent::__construct($elements);
    }
}
