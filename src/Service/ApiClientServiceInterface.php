<?php


namespace App\Service;


interface ApiClientServiceInterface
{
    public function call(string $uri = '', string $method = 'GET', array $params = []);
}