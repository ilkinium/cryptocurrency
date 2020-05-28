<?php


namespace App\Service;


use App\Entity\ExchangeRates;
use Doctrine\ORM\EntityManagerInterface;

class ExchangeRatePersister
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * ExchangeRatePersister constructor.
     * @param  EntityManagerInterface  $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param  ExchangeRateInterface  $rate
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

    /**
     * Flush entities
     */
    public function save(): void
    {
        $this->entityManager->flush();
    }
}