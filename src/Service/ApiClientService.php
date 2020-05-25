<?php


namespace App\Service;


use App\Helper\BlockchainInfoApiClient;

class ApiClientService implements ApiClientServiceInterface
{

    /**
     * @var BlockchainInfoApiClient
     */
    private $apiClient;

    /**
     * ApiClientService constructor.
     * @param  BlockchainInfoApiClient  $apiClient
     */
    public function __construct(BlockchainInfoApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function call(string $uri = '', string $method = 'GET', array $params = [])
    {
        return $this->apiClient->call($uri, $method, $params);
    }
}