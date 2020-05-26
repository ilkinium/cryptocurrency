<?php

namespace App\Command;

use App\Service\ApiClientServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GetExchangeRatesCommand extends Command
{

    /**
     * @var string
     */
    protected static $defaultName = "get-rates";

    /**
     * @var ApiClientServiceInterface
     */
    private ApiClientServiceInterface $apiClientService;


    public function __construct(ApiClientServiceInterface $apiClientService)
    {
        parent::__construct();

        $this->apiClientService = $apiClientService;
    }


    protected function configure()
    {
        $this->setDescription('Consume data via api client');
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io   = new SymfonyStyle($input, $output);
        $this->apiClientService->retrieveData();
        $io->success('Success. Data retrieved from api!');
        
        return 0;
    }
}
