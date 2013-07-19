<?php
namespace DevMStudy\Tdd\Bc\Osaka;
use Codeception\Util\Stub;

class BeverageStockTest extends \Codeception\TestCase\Test
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
    public function testGetterAndSetter()
    {
        $I = $this->codeGuy;

        $I->expect("Getter work correctly");
        $stock = new BeverageStock("コーラ", 120, 5);

        $this->assertEquals("コーラ", $stock->getName());
        $this->assertEquals(120, $stock->getPrice());
        $this->assertEquals(5, $stock->getQuantity());
    }

}