<?php
namespace DevMStudy\Tdd\Bc\Osaka;
use Codeception\Util\Stub;

class BeverageTest extends \Codeception\TestCase\Test
{
    /**
     * @var \CodeGuy
     */
    protected $codeGuy;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testBeverage()
    {
        $I = $this->codeGuy;

        $I->expect("コーラは120円");
        $cola = new Cola();
        $this->assertEquals("コーラ", $cola->getName());
        $this->assertEquals(120, $cola->getPrice());

        $I->expect("レッドブルは200円");
        $redBull = new RedBull();
        $this->assertEquals("レッドブル", $redBull->getName());
        $this->assertEquals(200, $redBull->getPrice());

        $I->expect("おいしい水は100円");
        $water = new Water();
        $this->assertEquals("おいしい水", $water->getName());
        $this->assertEquals(100, $water->getPrice());
    }

}