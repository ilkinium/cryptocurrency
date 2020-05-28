<?php


namespace App\Service;


abstract class ApiClientService implements ApiClientServiceInterface
{
    /**
     * @param  array  $data
     * @return ExchangeRateInterface
     */
    abstract protected function convert(array $data): ExchangeRateInterface;
}