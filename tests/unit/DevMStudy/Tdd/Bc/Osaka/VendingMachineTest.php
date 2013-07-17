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

        $insertMoney = function($amount) use ($V) {
            return function() use ($V, $amount) {
                $V->insertMoney(new Money($amount));
            };
        };

        $I->expect("1円玉が投入された場合は、投入金額に加算せず、それをそのまま釣り銭としてユーザに出力する。");
        $change = $I->getOutputString($insertMoney(1));
        $this->assertEquals("釣り: 1円", $change->__toString());
        $this->assertEquals(1690, $V->getTotalMoneyAmount());

        $I->expect("5円玉が投入された場合は、投入金額に加算せず、それをそのまま釣り銭としてユーザに出力する。");
        $change = $I->getOutputString($insertMoney(5));
        $this->assertEquals("釣り: 5円", $change->__toString());
        $this->assertEquals(1690, $V->getTotalMoneyAmount());

        $I->expect("2000円札が投入された場合は、投入金額に加算せず、それをそのまま釣り銭としてユーザに出力する。");
        $change = $I->getOutputString($insertMoney(2000));
        $this->assertEquals("釣り: 2000円", $change->__toString());
        $this->assertEquals(1690, $V->getTotalMoneyAmount());

        $I->expect("5000円札が投入された場合は、投入金額に加算せず、それをそのまま釣り銭としてユーザに出力する。");
        $change = $I->getOutputString($insertMoney(5000));
        $this->assertEquals("釣り: 5000円", $change->__toString());
        $this->assertEquals(1690, $V->getTotalMoneyAmount());

        $I->expect("10000円札が投入された場合は、投入金額に加算せず、それをそのまま釣り銭としてユーザに出力する。");
        $change = $I->getOutputString($insertMoney(10000));
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

        $payBack = function() use ($V) {
            $V->payBack();
        };

        $I->expect("払い戻し操作を行うと、投入金額の総計を釣り銭として出力する。");
        $V->insertMoney(new Money(100));
        $change = $I->getOutputString($payBack);
        $this->assertEquals("釣り: 100円", $change->__toString());

        $I->expect("購入後に払い戻し操作を行うと、投入金額の総計から購入代金を引いた金額を釣り銭として出力する。");
        $V->insertMoney(new Money(1000));
        $V->purchase();
        $change = $I->getOutputString($payBack);
        $this->assertEquals("釣り: 880円", $change->__toString());
    }

    public function testPurchase()
    {
        $I = $this->codeGuy;
        $V = new VendingMachine();

        $I->expect("投入金額が不足している場合、購入操作を行っても何もしない");
        $beverage = $V->purchase();
        $this->assertNull($beverage);

        $I->expect("購入操作を行うと、飲み物の在庫を減らし、売り上げ金額を増やす。");
        $V->insertMoney(new Money(1000));
        $beverage = $V->purchase();
        $stock = $V->getBeverageStock();

        $this->assertEquals("DevMStudy\\Tdd\\Bc\\Osaka\\Cola", get_class($beverage));
        $this->assertEquals(4, $stock->getQuantity());
        $this->assertEquals(120, $V->getSales());
        $this->assertEquals(880, $V->getTotalMoneyAmount());
    }

    public function testCanPurchase()
    {
        $I = $this->codeGuy;
        $V = new VendingMachine();

        $I->expect("投入金額が不足している場合、飲み物を購入できない。");
        $V->insertMoney(new Money(10));
        $this->assertFalse($V->canPurchase());

        $I->expect("投入金額が足りている＆在庫がある場合、飲み物を購入できる。");
        $V->insertMoney(new Money(1000));
        $this->assertTrue($V->canPurchase());

        $I->expect("投入金額が足りている＆在庫がない場合、飲み物を購入できる。");
        for ($i = 0; $i < 5; $i++) {
            $V->purchase();
        }
        $this->assertFalse($V->canPurchase());
    }
}