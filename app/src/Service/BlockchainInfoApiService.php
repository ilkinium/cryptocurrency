<?php


namespace App\Service;

use App\ValueObject\ExchangeRate;
use App\ValueObject\ExchangeRateInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;

class BlockchainInfoApiService extends ApiClientService
{
    public const URL = 'https://blockchain.info/ticker';

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * BlockchainInfoApiService constructor.
     *
     * @param  LoggerInterface  $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function retrieveData(): array
    {
        return $this->consume();
    }

    /**
     * @return array
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    private function consume(): array
    {
        try {
            $client = HttpClient::create();
            $response = $client->request("GET", self::URL);
            // Responses are lazy: this code is executed as soon as headers are received
            if (Response::HTTP_OK !== $response->getStatusCode()) {
                $this->logger->error($response);

                return [];
            }
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());

            return [];
        }

        $rates = [];
        foreach ($response->toArray() as $key => $value) {
            $rates[] = $this->convert(array_merge(['key' => $key], $value));
        }

        return $rates;
    }

    /**
     * @param  array  $data
     * @return ExchangeRateInterface
     */
    protected function convert(array $data): ExchangeRateInterface
    {
        $rate = new ExchangeRate();
        $rate->setCode($data['key']);
        $rate->setValue($data['15m']);

        return $rate;
    }
}
