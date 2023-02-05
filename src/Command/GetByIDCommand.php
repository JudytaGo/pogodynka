<?php

namespace App\Command;

use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'GetByID',
    description: 'Add a short description for your command',
)]
class GetByIDCommand extends Command
{
    private WeatherUtil $util;

    public function __construct(WeatherUtil $util)
    {
        $this->util = $util;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('id', InputArgument::REQUIRED, 'id');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $id = $input->getArgument('id');
        $output->writeln($id);
        if ($id) {
            $results = $this->util->getWeatherForLocation($id);
            foreach ($results as $result) {
                $date = $result->getDate()->format('Y-m-d');
                $city = $result->getLocation()->getCity();
                $country = $result->getLocation()->getCountry();
                $temperature = $result->getCelsius();
                $output->writeln("{$city}, {$country}, {$date}, {$temperature}C");
            }
        }
//        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
