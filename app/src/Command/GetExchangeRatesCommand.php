<?php

namespace App\Command;

use App\Repository\ExchangeRatesRepository;
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
    protected static $defaultName = 'exchange-api:get-rates';

    /**
     * @var ApiClientServiceInterface
     */
    private ApiClientServiceInterface $apiClientService;

    /**
     * @var ExchangeRatesRepository
     */
    private ExchangeRatesRepository $exchangeRatesRepository;


    /**
     * GetExchangeRatesCommand constructor.
     *
     * @param ApiClientServiceInterface $apiClientService
     * @param ExchangeRatesRepository   $exchangeRatesRepository
     */
    public function __construct(ApiClientServiceInterface $apiClientService, ExchangeRatesRepository $exchangeRatesRepository)
    {
        parent::__construct();

        $this->apiClientService        = $apiClientService;
        $this->exchangeRatesRepository = $exchangeRatesRepository;

    }


    /**
     * Configure command
     */
    protected function configure()
    {
        $this->setDescription('Consume data via api client');
    }


    /**
     * @param  InputInterface  $input
     * @param  OutputInterface  $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $output->writeln(
            [
                '==============================',
                '||  Retrieve data from API  ||',
                '==============================',
                '',
            ]
        );
        $rates = $this->apiClientService->retrieveData();
        if (isset($rates) && count($rates)){
            $io->newLine(1);
            $output->writeln(sprintf('%s rows retrieved via API', count($rates)));
        }
        $this->exchangeRatesRepository->save($rates);
        $io->success('Success. Data retrieved from api!');

        return 0;

    }


}
