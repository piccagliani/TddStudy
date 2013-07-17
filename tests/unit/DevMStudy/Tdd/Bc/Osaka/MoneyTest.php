<?php
namespace DevMStudy\Tdd\Bc\Osaka;
use Codeception\Util\Stub;

class MoneyTest extends \Codeception\TestCase\Test
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
    public function testGetAmount()
    {
        $I = $this->codeGuy;
        $m = new Money(100);
        $I->expect("getAmount returns 100");
        $this->assertEquals(100, $m->getAmount());
    }

}