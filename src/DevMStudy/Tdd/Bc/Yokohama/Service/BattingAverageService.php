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
        if ($player->getPlateAppearances() === 0) {
            // 打席数が0の場合は、打率を計算しない
            $player->setBattingAverage('----');
        } else if ($player->getAtBats() === 0) {
            // 打席数が0でなく、打数が0の場合は「0.000」と計算する
            $player->setBattingAverage(".000");
        } else {
            $average = round($player->getHits() / $player->getAtBats(), 3);
            $player->setBattingAverage(substr(sprintf("%.3F", $average), 1));
        }

        return $player;
    }
}