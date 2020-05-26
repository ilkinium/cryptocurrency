<?php


namespace App\Helper;


use App\Entity\ExchangeRates;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use HttpException;
use Symfony\Component\HttpClient\HttpClient;

class BlockchainInfoApiClient
{
    public const URL = 'https://blockchain.info/ticker';
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function call(string $uri = '', string $method = 'GET', array $params = [])
    {
        $response = $this->consume(self::URL, $method);
        return $this->save($response);
    }

    private function consume(string $uri = '', string $method = 'GET', array $params = []): ?array
    {
        $client = HttpClient::create();

        $response = $client->request($method, $uri);
        // Responses are lazy: this code is executed as soon as headers are received
        if (200 !== $response->getStatusCode()) {
            throw new HttpException("200");
        }

        return $response->toArray();
    }

    private function save(array $data = []): void
    {
        $dateTime = new DateTime('now');
        foreach ($data as $code => $value) {
            $this->entityManager
                ->getRepository(ExchangeRates::class)
                ->save(
                    $this->newInstance([
                        'code' => (string) $code,
                        'value' => (float) $value['15m'],
                        'datetime' => $dateTime
                    ])
                );
        }
    }

    private function newInstance(array $data): ExchangeRates
    {
        $newRate = new ExchangeRates();
        $newRate->setCode($data['code']);
        $newRate->setValue($data['value']);
        $newRate->setDatetime($data['datetime']);
        return $newRate;
    }

}