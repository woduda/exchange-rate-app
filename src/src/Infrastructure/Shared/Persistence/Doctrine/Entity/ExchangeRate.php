<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Persistence\Doctrine\Entity;

use Domain\Shared\ValueObject\CurrencyCode;
use Domain\Shared\ValueObject\CurrencyName;
use Domain\Shared\ValueObject\CurrencyRate;
use Doctrine\ORM\Mapping AS ORM;
use Infrastructure\Shared\Persistence\Doctrine\Repository\ExchangeRateRepository;
use DateTimeImmutable;

/**
 * @ORM\Entity(repositoryClass=ExchangeRateRepository::class)
 * @ORM\Table(name="exchange_rates")
 */
class ExchangeRate
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @ORM\Column(type="currency_name", length=255)
     */
    private CurrencyName $name;

    /**
     * @ORM\Column(type="currency_code", length=3)
     */
    private CurrencyCode $code;

    /**
     * @ORM\Column(type="currency_rate")
     */
    private CurrencyRate $rate;

    /**
     * @ORM\Column(type="date_immutable")
     */
    private ?DateTimeImmutable $date;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): CurrencyName
    {
        return $this->name;
    }

    public function setName(CurrencyName $name): void
    {
        $this->name = $name;
    }


    public function getCode(): CurrencyCode
    {
        return $this->code;
    }

    public function setCode(CurrencyCode $code): void
    {
        $this->code = $code;
    }

    public function getRate(): CurrencyRate
    {
        return $this->rate;
    }
    public function setRate(CurrencyRate $rate): void
    {
        $this->rate = $rate;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(DateTimeImmutable $date): void
    {
        $this->date = $date;
    }
}
