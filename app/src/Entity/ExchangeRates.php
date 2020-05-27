<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use App\Repository\ExchangeRatesRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExchangeRatesRepository::class)
 * @ApiResource(
 *     collectionOperations={"get"={"method"="GET"}},
 *     itemOperations={"get"={"method"="GET"}}
 * )
 * @ApiFilter(DateFilter::class, properties={"datetime"})
 */
class ExchangeRates
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private ?string $code;

    /**
     * @ORM\Column(type="float")
     */
    private ?float $value;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTimeInterface $datetime;


    public function toArray()
    {
        return [
            'id'       => $this->getId(),
            'code'     => $this->getCode(),
            'value'    => $this->getValue(),
            'dateTime' => $this->getDatetime(),
        ];

    }


    public function getId(): ?int
    {
        return $this->id;

    }


    public function getCode(): ?string
    {
        return $this->code;

    }


    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;

    }


    public function getValue(): ?float
    {
        return $this->value;

    }


    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;

    }


    public function getDatetime(): ?DateTimeInterface
    {
        return $this->datetime;

    }


    public function setDatetime(DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

        return $this;

    }

}
