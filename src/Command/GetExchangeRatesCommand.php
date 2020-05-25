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
    protected static $defaultName = 'get-rates';
    /**
     * @var ApiClientServiceInterface
     */
    private $apiClientService;

    public function __construct(ApiClientServiceInterface $apiClientService)
    {
        parent::__construct();

        $this->apiClientService = $apiClientService;
    }

    protected function configure()
    {
        $this
            ->setDescription('Consume data via api client')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        $result = $this->apiClientService->call();

        $io->writeln($result);

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return 0;
    }
}
