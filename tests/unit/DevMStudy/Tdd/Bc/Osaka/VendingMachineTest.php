<?php
namespace DevMStudy\Tdd\Bc\Osaka;
use Codeception\Util\Stub;

class VendingMachineTest extends \Codeception\TestCase\Test
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
    public function testInsertMoney()
    {
        $I = $this->codeGuy;
        $V = new VendingMachine();

        $I->expect("10円玉、50円玉、100円玉、500円玉、1000円札を１つずつ投入できる。");
        $V->insertMoney(new Money(10));
        $V->insertMoney(new Money(50));
        $V->insertMoney(new Money(100));
        $V->insertMoney(new Money(500));
        $V->insertMoney(new Money(1000));

        $I->expect("投入は複数回できる。");
        $V->insertMoney(new Money(10));
        $V->insertMoney(new Money(10));
        $V->insertMoney(new Money(10));
    }

    public function testGetTotalMoneyAmount()
    {
        $I = $this->codeGuy;
        $V = new VendingMachine();

        $I->expect("投入金額の総計を取得できる。");
        $V->insertMoney(new Money(10));
        $V->insertMoney(new Money(50));
        $V->insertMoney(new Money(100));

        $this->assertEquals(160, $V->getTotalMoneyAmount());
    }

    public function testPayBack()
    {
        $I = $this->codeGuy;
        $V = new VendingMachine();

        $I->expect("払い戻し操作を行うと、投入金額の総計を釣り銭として出力する。");
        $V->insertMoney(new Money(100));
        $change = $I->getOutputString(function() use ($V) {
            $V->payBack();
        });
        $this->assertEquals("釣り: 100円", $change->__toString());
    }
}