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

    public function testConstruct()
    {
        $I = $this->codeGuy;
        $V = new VendingMachine();

        $I->expect("初期状態で、コーラ（値段:120円、名前”コーラ”）を5本格納している。");
        $stock = $V->getBeverageStock();
        $this->assertEquals("コーラ", $stock->getName());
        $this->assertEquals(120, $stock->getPrice());
        $this->assertEquals(5, $stock->getQuantity());
    }

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
        $this->assertEquals(1660, $V->getTotalMoneyAmount());

        $I->expect("投入は複数回できる。");
        $V->insertMoney(new Money(10));
        $V->insertMoney(new Money(10));
        $V->insertMoney(new Money(10));
        $this->assertEquals(1690, $V->getTotalMoneyAmount());

        $I->expect("1円玉が投入された場合は、投入金額に加算せず、それをそのまま釣り銭としてユーザに出力する。");
        $change = $I->getOutputString(function() use ($V) {
            $V->insertMoney(new Money(1));
        });
        $this->assertEquals("釣り: 1円", $change->__toString());
        $this->assertEquals(1690, $V->getTotalMoneyAmount());

        $I->expect("5円玉が投入された場合は、投入金額に加算せず、それをそのまま釣り銭としてユーザに出力する。");
        $change = $I->getOutputString(function() use ($V) {
            $V->insertMoney(new Money(5));
        });
        $this->assertEquals("釣り: 5円", $change->__toString());
        $this->assertEquals(1690, $V->getTotalMoneyAmount());

        $I->expect("2000円札が投入された場合は、投入金額に加算せず、それをそのまま釣り銭としてユーザに出力する。");
        $change = $I->getOutputString(function() use ($V) {
            $V->insertMoney(new Money(2000));
        });
        $this->assertEquals("釣り: 2000円", $change->__toString());
        $this->assertEquals(1690, $V->getTotalMoneyAmount());

        $I->expect("5000円札が投入された場合は、投入金額に加算せず、それをそのまま釣り銭としてユーザに出力する。");
        $change = $I->getOutputString(function() use ($V) {
            $V->insertMoney(new Money(5000));
        });
        $this->assertEquals("釣り: 5000円", $change->__toString());
        $this->assertEquals(1690, $V->getTotalMoneyAmount());

        $I->expect("10000円札が投入された場合は、投入金額に加算せず、それをそのまま釣り銭としてユーザに出力する。");
        $change = $I->getOutputString(function() use ($V) {
            $V->insertMoney(new Money(10000));
        });
        $this->assertEquals("釣り: 10000円", $change->__toString());
        $this->assertEquals(1690, $V->getTotalMoneyAmount());
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