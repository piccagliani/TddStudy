<?php
namespace DevMStudy\Tdd\Bc\Osaka;
use Codeception\Util\Stub;

class BeverageLaneTest extends \Codeception\TestCase\Test
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
    public function testConstruct()
    {
        $I = $this->codeGuy;

        $I->expect("初期化が正常に行われる");
        $L = new BeverageLane("コーラ", 120);
        $this->assertEquals("コーラ", $L->getBeverageName());
        $this->assertEquals(120, $L->getBeveragePrice());
    }
}