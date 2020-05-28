<?php


namespace App\Service;


class ExchangeRate implements ExchangeRateInterface
{
    /**
     * @var
     */
    protected $code;

    /**
     * @var
     */
    protected $value;

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param  mixed  $code
     */
    public function setCode($code): void
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param  mixed  $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }
}