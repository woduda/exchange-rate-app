<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Persistence\Doctrine\Repository;

use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;
use Domain\ExchangeRate\Dto\ExchangeCurrenciesDto;
use Domain\ExchangeRate\Dto\ExchangeRateCollectionDto;
use Domain\ExchangeRate\Dto\ExchangeRateDto;
use Domain\ExchangeRate\Factory\ExchangeCurrenciesDtoFactory;
use Domain\ExchangeRate\Factory\ExchangeRateCollectionDtoFactory;
use Domain\ExchangeRate\Repository\ExchangeRateRepository as ExchangeRateRepositoryInterface;
use Domain\Shared\Dto\DomainDto;
use Domain\Shared\ValueObject\CurrencyCode;
use Infrastructure\Factory\ExchangeRateDtoFactory;
use Infrastructure\Shared\Persistence\Doctrine\Entity\ExchangeRate;
use function GuzzleHttp\Psr7\str;

class ExchangeRateRepository extends ServiceEntityRepository implements ExchangeRateRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExchangeRate::class);
    }

    public function createFromCollection(ExchangeRateCollectionDto $exchangeRateCollectionDto): void
    {
        if ($exchangeRateCollectionDto->isEmpty() === false) {
            foreach ($exchangeRateCollectionDto as $item) {
                /** @var ExchangeRateDto $item */
                $exchangeRate = $this->findOneBy([
                    'code' => (string)$item->getCurrencyCode(),
                    'date' => $item->getCurrencyDate()
                ]);

                if (($exchangeRate instanceof ExchangeRate) === false) {
                    $exchangeRate = new ExchangeRate();
                    $exchangeRate->setCode($item->getCurrencyCode());
                    $exchangeRate->setName($item->getCurrencyName());
                    $exchangeRate->setRate($item->getCurrencyRate());
                    $exchangeRate->setDate($item->getCurrencyDate());

                    $this->getEntityManager()->persist($exchangeRate);
                }
            }

            $this->getEntityManager()->flush();
        }
    }

    public function getAllForDate(DateTimeImmutable $date): ExchangeRateCollectionDto
    {
        $exchangeRates = $this->findBy(['date' => $date]);

        if (empty($exchangeRates) === false) {
            return ExchangeRateCollectionDtoFactory::createFromEntities($exchangeRates);
        }

        return new ExchangeRateCollectionDto();
    }

    public function getAllCurrencyCodes(): ExchangeCurrenciesDto
    {
        $codes = $this->createQueryBuilder('er')
            ->select('er.code')
            ->groupBy('er.code')
            ->getQuery()
            ->getArrayResult();

        return ExchangeCurrenciesDtoFactory::createFromRaw($codes);
    }

    public function findOne(CurrencyCode $currencyCode, DateTimeImmutable $currencyDate): ?ExchangeRateDto
    {
        /** @var ExchangeRate|null $exchangeRate */
        $exchangeRate = $this
            ->matching(
                (string)$currencyCode !== DomainDto::DEFAULT_CURRENCY_CODE
                ? Criteria::create()
                    ->where(Criteria::expr()->eq('code', (string)$currencyCode))
                    ->andWhere((Criteria::expr()->lte('date', $currencyDate)))
                    ->orderBy(['date' => Criteria::DESC])
                : Criteria::create()
                    ->where((Criteria::expr()->eq('code', DomainDto::DEFAULT_CURRENCY_CODE)))
                    ->orderBy(['date' => Criteria::DESC])
            )
            ->first();

        if ($exchangeRate instanceof ExchangeRate) {
            return ExchangeRateDtoFactory::createFromEntity($exchangeRate);
        }

        return null;
    }
}
