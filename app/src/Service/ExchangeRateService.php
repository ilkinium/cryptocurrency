<?php


namespace App\Service;


abstract class ExchangeRateService implements ApiClientServiceInterface
{
    abstract protected function convert(array $data): ExchangeRateInterface;
}