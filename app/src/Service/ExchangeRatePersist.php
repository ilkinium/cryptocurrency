<?php


namespace App\Service;


use App\Entity\ExchangeRates;
use App\Repository\ExchangeRatesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class ExchangeRatePersist
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * ExchangeRatePersist constructor.
     * @param  EntityManagerInterface  $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param ExchangeRateInterface $rate
     * @return $this
     */
    public function persistRates(ExchangeRateInterface $rate): self
    {
        $newRate = new ExchangeRates();
        $newRate->setCode($rate->getCode());
        $newRate->setValue($rate->getValue());
        $newRate->setDatetime(new \DateTime('now'));

        $this->entityManager->persist($newRate);

        return $this;
    }
}