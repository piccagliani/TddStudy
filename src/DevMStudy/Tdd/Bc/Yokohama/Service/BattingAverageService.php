<?php
namespace DevMStudy\Tdd\Bc\Yokohama\Service;

use DevMStudy\Tdd\Bc\Yokohama\Entity\Player;

/**
 * Class BattingAverageCalcurator
 * @package DevMStudy\Tdd\Bc\Yokohama
 * @see http://devtesting.jp/tddbc/?TDDBC%E6%A8%AA%E6%B5%9C%2F%E8%AA%B2%E9%A1%8C
 */
class BattingAverageService
{
    /**
     * @param Player $player
     * @return Player
     */
    public function calculateBattingAverage(Player $player)
    {
        if ($player->getPlateAppearances() == 0) {
            // 打席数が0の場合は、打率を計算しない
            $player->setBattingAverage('----');
        } else if ($player->getAtBats() == 0) {
            // 打席数が0でなく、打数が0の場合は「0.000」と計算する
            $player->setBattingAverage(".000");
        } else {
            $average = round($player->getHits() / $player->getAtBats(), 3);
            $player->setBattingAverage(substr(sprintf("%.3F", $average), 1));
        }

        return $player;
    }

    public function makeBattingAverageRankingFromTsv($filename)
    {
        $players = [];
        $fp = fopen($filename, "r");
        while (($data = fgetcsv($fp, 0, "\t")) !== false) {
            $player = new Player();
            $player->setName($data[0]);
            $player->setPlateAppearances($data[1]);
            $player->setAtBats($data[2]);
            $player->setHits($data[3]);
            $players[] = $this->calculateBattingAverage($player);
        }
        fclose($fp);

        usort($players, function($a, $b) {
            if ($b->getBattingAverage() === $a->getBattingAverage()) {
                return 0;
            }
            if ($a->getBattingAverage() === '----') {
                return 1;
            }
            if ($b->getBattingAverage() === '----') {
                return -1;
            }

            return ($b->getBattingAverage() * 1000) - ($a->getBattingAverage() * 1000);
        });

        return $players;
    }
}