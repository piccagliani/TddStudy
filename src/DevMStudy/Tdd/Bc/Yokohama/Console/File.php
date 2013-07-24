<?php
namespace DevMStudy\Tdd\Bc\Yokohama\Console;

use DevMStudy\Tdd\Bc\Yokohama\Service\BattingAverageService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class File extends Command
{
    protected function configure()
    {
        $this
            ->setName("tddbc:ykhm:file")
            ->addArgument("filename", InputArgument::REQUIRED, "");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filename = $input->getArgument("filename");

        if (!file_exists($filename) || !is_readable($filename)) {
            throw new \Exception("'" . $filename . "' is not found or unreadable.");
        }

        $service = new BattingAverageService();
        $ranking = $service->makeBattingAverageRankingFromTsv($filename);

        foreach ($ranking as $rank => $player) {
            echo str_pad(($rank + 1), 2, " ", STR_PAD_LEFT) . ". " . $player->getBattingAverage() . " " . $player->getName() . "\n";
        }
    }
}