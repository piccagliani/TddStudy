<?php
namespace DevMStudy\Tdd\Bc\Yokohama\Entity;
use Codeception\Util\Stub;

class PlayerTest extends \Codeception\TestCase\Test
{
    /**
     * @var \CodeGuy
     */
    protected $codeGuy;

    /**
     * @var Player
     */
    protected $player;

    protected function _before()
    {
        $this->player = new Player();
    }

    protected function _after()
    {
    }

    // tests
    public function testGetterAndSetter()
    {
        $I = $this->codeGuy;

        $I->expect("getter and setter for \$plateAppearances works correct");
        $this->player->setPlateAppearances(10);
        $this->assertEquals(10, $this->player->getPlateAppearances());

        $I->expect("getter and setter for \$hits works correct");
        $this->player->setHits(10);
        $this->assertEquals(10, $this->player->getHits());

        $I->expect("getter and setter for \$atBats works correct");
        $this->player->setAtBats(10);
        $this->assertEquals(10, $this->player->getAtBats());
    }
}