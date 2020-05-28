<?php


namespace App\ValueObject;


interface ExchangeRateInterface
{
    /**
     * @return mixed
     */
    public function getCode();

    /**
     * @param  mixed  $code
     */
    public function setCode($code);

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @param  mixed  $value
     */
    public function setValue($value);
}