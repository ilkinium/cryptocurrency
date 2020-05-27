<?php

namespace App\Repository;

use App\Entity\ExchangeRates;
use App\Service\ExchangeRateInterface;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExchangeRates|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExchangeRates|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExchangeRates[]    findAll()
 * @method ExchangeRates[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExchangeRatesRepository extends ServiceEntityRepository
{
    /**
     * ExchangeRatesRepository constructor.
     *
     * @param  ManagerRegistry  $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExchangeRates::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(): void
    {
        $this->_em->flush();
    }

    /**
     * @param ExchangeRateInterface $rate
     * @return $this
     */
    private function persistRates(ExchangeRateInterface $rate): self
    {
        $newRate = new ExchangeRates();
        $newRate->setCode($rate->getCode());
        $newRate->setValue($rate->getValue());
        $newRate->setDatetime(new \DateTime('now'));

        $this->_em->persist($newRate);

        return $this;
    }

}
