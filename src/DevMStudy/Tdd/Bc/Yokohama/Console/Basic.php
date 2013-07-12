<?php
namespace DevMStudy\Tdd\Bc\Yokohama\Console;

use DevMStudy\Tdd\Bc\Yokohama\Service\BattingAverageService;
use DevMStudy\Tdd\Bc\Yokohama\Entity\Player;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Basic extends Command
{
    protected function configure()
    {
        $this
            ->setName("tddbc:ykhm:basic")
            ->addArgument("PA", InputArgument::REQUIRED, "plate appearances")
            ->addArgument("AB", InputArgument::REQUIRED, "at bats")
            ->addArgument("H", InputArgument::REQUIRED, "hits");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pa = $input->getArgument("PA");
        $ab = $input->getArgument("AB");
        $h = $input->getArgument("H");

        $player = new Player();
        $player->setPlateAppearances($pa);
        $player->setAtBats($ab);
        $player->setHits($h);

        $service = new BattingAverageService();
        $average = $service->calculateBattingAverage($player);
        $output->writeln("Average: " . $average);
    }
}