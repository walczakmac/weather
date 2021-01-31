<?php

namespace App\UserInterface\Console;

use App\Application\Forecasts;
use App\Application\Musement;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PrintForecastCommand extends Command
{
    /**
     * @var Musement
     */
    private $musement;

    /**
     * @var Forecasts
     */
    private $forecasts;

    public function __construct(
        Musement $musement,
        Forecasts $forecasts
    )
    {
        parent::__construct('forecast:print');

        $this->musement = $musement;
        $this->forecasts = $forecasts;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $cities = $this->musement->getCities();
        foreach($cities as $city) {
            $city->addForecasts(...$this->forecasts->getForecastFor($city));
            $output->writeln(sprintf('Processed city %s', $city->printForecast()));
        }

        return 0;
    }
}
