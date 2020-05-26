<?php


namespace App\Service;

use App\Repository\ExchangeRatesRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class BlockchainInfoApiService implements ApiClientServiceInterface
{
    public const URL = 'https://blockchain.info/ticker';

    /**
     * @var ExchangeRatesRepository
     */
    private ExchangeRatesRepository $exchangeRatesRepository;
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;


    /**
     * BlockchainInfoApiService constructor.
     *
     * @param  ExchangeRatesRepository  $exchangeRatesRepository
     * @param  LoggerInterface  $logger
     */
    public function __construct(ExchangeRatesRepository $exchangeRatesRepository, LoggerInterface $logger)
    {
        $this->exchangeRatesRepository = $exchangeRatesRepository;
        $this->logger = $logger;
    }


    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function retrieveData(): void
    {
        $response = $this->consume();
        $this->exchangeRatesRepository->save($response);
    }

    private function consume(): ?array
    {
        try {
            $client = HttpClient::create();
            $response = $client->request("GET", self::URL);
            // Responses are lazy: this code is executed as soon as headers are received
            if (Response::HTTP_OK !== $response->getStatusCode()) {
                throw new HttpException();
            }
        } catch (TransportExceptionInterface $e) {
            $this->logger->error(
                $e->getMessage()
            );
            return null;
        }

        return $response->toArray();
    }
}
