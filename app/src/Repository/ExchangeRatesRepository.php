<?php

namespace App\Repository;

use App\Entity\ExchangeRates;
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
     * @param  array  $rates
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(array $rates): void
    {
        $this->persistRates($rates);
        $this->_em->flush();
    }

    /**
     * 
     * @param  array $rates
     * @return $this
     */
    private function persistRates(array $rates): self
    {
        $dateTime = new DateTime('now');
        foreach ($rates as $code => $rate) {
            $newRate = new ExchangeRates();
            $newRate->setCode($code);
            $newRate->setValue($rate['15m']);
            $newRate->setDatetime($dateTime);
            $this->_em->persist($newRate);
        }

        return $this;
    }

}
