<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportDataCommand extends Command
{
    protected static $defaultName = 'app:import';

    protected function configure()
    {
        $this
            ->setDescription('Import beers data from external API')
            ->addArgument('url', InputArgument::REQUIRED, 'API URL');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $url = $input->getArgument('url');

        if ($url) {
            $io->note(sprintf('You passed an argument: %s', $url));
        } else {
            $io->note('URL argument is required.');
            exit(1);
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
    }
}
