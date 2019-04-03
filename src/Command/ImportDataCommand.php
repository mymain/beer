<?php

declare(strict_types=1);

namespace App\Command;

use App\Importer\DataImporter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportDataCommand extends Command
{
    protected static $defaultName = 'app:import';

    /* @var DataImporter */
    protected $dataImporter;
    
    public function __construct(DataImporter $dataImporter)
    {
        parent::__construct();
        $this->dataImporter = $dataImporter;
    }

    protected function configure()
    {
        $this
            ->setDescription('Import beers data from external API')
            ->addArgument('url', InputArgument::OPTIONAL, 'API URL (default http://ontariobeerapi.ca/beers)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        
        $url = $input->getArgument('url');

        if ($url) {
            $io->note(sprintf('You passed an argument: %s', $url));
        } else {
            $url = 'http://ontariobeerapi.ca/beers';
        }

        $this->dataImporter->setOutput($output);
        
        if ($this->dataImporter->import($url)) {
            $io->success('The data import was successful!');
        } else {
            $io->error('Some error has occurred on the data import.');
        }
        
    }
}
