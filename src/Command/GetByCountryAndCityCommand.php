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
    name: 'GetByCountryAndCity',
    description: 'Add a short description for your command',
)]
class GetByCountryAndCityCommand extends Command
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
            ->addArgument('country', InputArgument::REQUIRED, 'country')
            ->addArgument('city', InputArgument::REQUIRED, 'city');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $country = $input->getArgument('country');
        $city = $input->getArgument('city');

        if ($country && $city) {
            $results = $this->util->getWeatherForCountryAndCity($country, $city);
            foreach ($results as $result) {
                $date = $result->getDate()->format('Y-m-d');
                $temperature = $result->getCelsius();
                $output->writeln("{$city}, {$country}, {$date} {$temperature}C");
            }
        }

        return Command::SUCCESS;
    }
}