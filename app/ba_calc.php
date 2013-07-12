<?php
require_once __DIR__ . "/../vendor/autoload.php";

/**
 * Batting Average Calculator
 */
if (count($argv) !== 4) {
    echo "Usage: {$argv[0]} PA AB H\n";
    exit;
}

$player = new \DevMStudy\Tdd\Bc\Yokohama\Player();
$player->setPlateAppearances($argv[1]);
$player->setAtBats($argv[2]);
$player->setHits($argv[3]);

$calculator = new \DevMStudy\Tdd\Bc\Yokohama\BattingAverageCalculator();
$average = $calculator->calculateBattingAverage($player);

echo "Average: " . $average . "\n";

