<?php

namespace App\Command;

use App\Service\ApiClientServiceInterface;
use App\Service\ExchangeRatePersister;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
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
     * @var ExchangeRatePersister
     */
    private ExchangeRatePersister $exchangeRatePersister;


    /**
     * GetExchangeRatesCommand constructor.
     *
     * @param  ApiClientServiceInterface  $apiClientService
     * @param  ExchangeRatePersister  $exchangeRatePersister
     */
    public function __construct(
        ApiClientServiceInterface $apiClientService,
        ExchangeRatePersister $exchangeRatePersister
    ) {
        parent::__construct();

        $this->apiClientService = $apiClientService;
        $this->exchangeRatePersister = $exchangeRatePersister;
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

        $rates = $this->apiClientService->retrieveData();
        $output->writeln(sprintf('%s rows retrieved via API', count($rates)));
        if (!empty($rates)) {
            foreach ($rates as $rate) {
                $this->exchangeRatePersister->persistRates($rate);
            }
            $this->exchangeRatePersister->save();

            $io->success('Success. Data retrieved from api!');
        } else {
            $io->warning('No data retrieved from api!');
        }

        return 0;
    }

}
