<?php
namespace DevMStudy\Tdd\Bc\Yokohama\Service;

use Codeception\Configuration;
use Codeception\Util\Stub;
use DevMStudy\Tdd\Bc\Yokohama\Entity\Player;

class BattingAverageServiceTest extends \Codeception\TestCase\Test
{
    /**
     * @var \CodeGuy
     */
    protected $codeGuy;

    /**
     * @var BattingAverageService
     */
    protected $service;

    protected function _before()
    {
        $this->service = new BattingAverageService();
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
        $this->assertEquals(".310", $this->service->calculateBattingAverage($player)->getBattingAverage());

        $I->expect("打席数が0の場合は、打率を計算しない");
        $player->setPlateAppearances(0);
        $this->assertEquals("----", $this->service->calculateBattingAverage($player)->getBattingAverage());

        $I->expect("打席数が0でなく、打数が0の場合は「.000」と計算する");
        $player->setPlateAppearances(749);
        $player->setAtBats(0);
        $this->assertEquals(".000", $this->service->calculateBattingAverage($player)->getBattingAverage());
    }

    public function testMakeBattingAverageRankingFromTsv()
    {
        $I = $this->codeGuy;
        $data = Configuration::dataDir() . "DevMStudy/Tdd/Bc/Yokohama/ba.txt";
        $ranking = $this->service->makeBattingAverageRankingFromTsv($data);

        $this->assertEquals("ルナ", $ranking[0]->getName());
        $this->assertEquals(".369", $ranking[0]->getBattingAverage());
        $this->assertEquals("マートン", $ranking[1]->getName());
        $this->assertEquals(".332", $ranking[1]->getBattingAverage());
        $this->assertEquals("ブランコ", $ranking[2]->getName());
        $this->assertEquals(".324", $ranking[2]->getBattingAverage());
        $this->assertEquals("バレンティン", $ranking[3]->getName());
        $this->assertEquals(".313", $ranking[3]->getBattingAverage());
        $this->assertEquals("中村　紀洋", $ranking[4]->getName());
        $this->assertEquals(".311", $ranking[4]->getBattingAverage());
        $this->assertEquals("ロペス", $ranking[5]->getName());
        $this->assertEquals(".31", $ranking[5]->getBattingAverage());
        $this->assertEquals("村田　修一", $ranking[6]->getName());
        $this->assertEquals(".299", $ranking[6]->getBattingAverage());
        $this->assertEquals("丸　佳浩", $ranking[7]->getName());
        $this->assertEquals(".298", $ranking[7]->getBattingAverage());
        $this->assertEquals("阿部　慎之助", $ranking[8]->getName());
        $this->assertEquals(".294", $ranking[8]->getBattingAverage());
        $this->assertEquals("新井　貴浩", $ranking[9]->getName());
        $this->assertEquals(".293", $ranking[9]->getBattingAverage());
        $this->assertEquals("打手真　千", $ranking[10]->getName());
        $this->assertEquals(".000", $ranking[10]->getBattingAverage());
        $this->assertEquals("二軍　落", $ranking[11]->getName());
        $this->assertEquals("----", $ranking[11]->getBattingAverage());
    }
}