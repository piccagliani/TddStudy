<?php
namespace DevMStudy\Tdd\Bc\Yokohama;
use Codeception\Util\Stub;

class BattingAverageCalculatorTest extends \Codeception\TestCase\Test
{
    /**
     * @var \CodeGuy
     */
    protected $codeGuy;

    /**
     * @var BattingAverageCalculator
     */
    protected $calcurator;

    protected function _before()
    {
        $this->calcurator = new BattingAverageCalculator();
    }

    protected function _after()
    {
    }

    // tests
    public function testCalculateBattingAverage()
    {
        $I = $this->codeGuy;
        $player = new Player();

        $I->expect("[打席数：749, 打数：686, 安打数：213] の場合打率は 「.310」");
        $player->setPlateAppearances(749);
        $player->setAtBats(686);
        $player->setHits(213);
        $this->assertEquals(".310", $this->calcurator->calculateBattingAverage($player));

        $I->expect("打席数が0の場合は、打率を計算しない");
        $player->setPlateAppearances(0);
        $this->assertEquals("----", $this->calcurator->calculateBattingAverage($player));

        $I->expect("打席数が0でなく、打数が0の場合は「.000」と計算する");
        $player->setPlateAppearances(749);
        $player->setAtBats(0);
        $this->assertEquals(".000", $this->calcurator->calculateBattingAverage($player));
    }
}