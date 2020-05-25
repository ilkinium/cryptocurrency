<?php


namespace App\Helper;


use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class BlockchainInfoApiClient
{
    const URL = 'https://blockchain.info/ticker';

    public function call(string $uri = '', string $method = 'GET', array $params = [])
    {
        return $response = $this->consume(self::URL, $method);
        $result = $this->save();
    }

    private function consume(string $uri = '', string $method = 'GET', array $params = [])
    {
        $client = HttpClient::create();

        $response = $client->request($method, $uri);
        // Responses are lazy: this code is executed as soon as headers are received
        if (200 !== $response->getStatusCode()) {
            throw new \HttpException("200");
        }

        return $response->getContent();
    }

    private function save($data)
    {

    }

}