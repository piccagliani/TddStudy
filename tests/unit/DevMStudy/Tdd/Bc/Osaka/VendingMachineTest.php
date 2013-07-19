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

        $I->expect("初期状態で、コーラ（値段: 120円、名前: コーラ）を5本格納している。");
        $stocks = $V->getBeverageStocks();
        $this->assertEquals("コーラ", $stocks[0]->getName());
        $this->assertEquals(120, $stocks[0]->getPrice());
        $this->assertEquals(5, $stocks[0]->getQuantity());

        $I->expect("初期状態で、レッドブル（値段: 200円、名前: レッドブル）を5本格納している。");
        $stocks = $V->getBeverageStocks();
        $this->assertEquals("レッドブル", $stocks[1]->getName());
        $this->assertEquals(200, $stocks[1]->getPrice());
        $this->assertEquals(5, $stocks[1]->getQuantity());

        $I->expect("初期状態で、水（値段:100円、名前: おいしい水）を5本格納している。");
        $stocks = $V->getBeverageStocks();
        $this->assertEquals("おいしい水", $stocks[2]->getName());
        $this->assertEquals(100, $stocks[2]->getPrice());
        $this->assertEquals(5, $stocks[2]->getQuantity());
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
        $I->seeInStandardOutput("釣り: 1円", $insertMoney(1));
        $this->assertEquals(1690, $V->getTotalMoneyAmount());

        $I->expect("5円玉が投入された場合は、投入金額に加算せず、それをそのまま釣り銭としてユーザに出力する。");
        $I->seeInStandardOutput("釣り: 5円", $insertMoney(5));
        $this->assertEquals(1690, $V->getTotalMoneyAmount());

        $I->expect("2000円札が投入された場合は、投入金額に加算せず、それをそのまま釣り銭としてユーザに出力する。");
        $I->seeInStandardOutput("釣り: 2000円", $insertMoney(2000));
        $this->assertEquals(1690, $V->getTotalMoneyAmount());

        $I->expect("5000円札が投入された場合は、投入金額に加算せず、それをそのまま釣り銭としてユーザに出力する。");
        $I->seeInStandardOutput("釣り: 5000円", $insertMoney(5000));
        $this->assertEquals(1690, $V->getTotalMoneyAmount());

        $I->expect("10000円札が投入された場合は、投入金額に加算せず、それをそのまま釣り銭としてユーザに出力する。");
        $I->seeInStandardOutput("釣り: 10000円", $insertMoney(10000));
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
        $I->seeInStandardOutput("釣り: 100円", function() use ($V) {
            $V->payBack();
        });
    }

    public function testPurchase()
    {
        $I = $this->codeGuy;
        $V = new VendingMachine();

        $I->expect("投入金額が不足している場合、購入操作を行っても何もしない");
        $beverage = $V->purchase("コーラ");
        $this->assertNull($beverage);
        $stocks = $V->getBeverageStocks();
        $this->assertEquals(5, $stocks[0]->getQuantity());
        $this->assertEquals(0, $V->getSales());

        $I->expect("存在しない商品を指定された場合、購入操作を行っても何もしない");
        $beverage = $V->purchase("ドクターペッパー");
        $this->assertNull($beverage);
        $this->assertEquals(5, $stocks[0]->getQuantity());
        $this->assertEquals(0, $V->getSales());

        $I->expect("購入操作を行うと、飲み物の在庫を減らし、売り上げ金額を増やし、釣り銭（投入金額とジュース値段の差分）を出力する。");
        $V->insertMoney(new Money(1000));
        $beverage = $I->seeInStandardOutput("釣り: 880円", function() use ($V) {
            return $V->purchase("コーラ");
        });
        $this->assertEquals("DevMStudy\\Tdd\\Bc\\Osaka\\Cola", get_class($beverage->__value()));

        $stocks = $V->getBeverageStocks();

        $this->assertEquals(4, $stocks[0]->getQuantity());
        $this->assertEquals(120, $V->getSales());
        $this->assertEquals(0, $V->getTotalMoneyAmount());
    }

    public function testCanPurchase()
    {
        $I = $this->codeGuy;
        $V = new VendingMachine();

        $I->expect("投入金額が不足している場合、飲み物を購入できない。");
        $V->insertMoney(new Money(10));
        $this->assertFalse($V->canPurchase("コーラ"));

        $I->expect("投入金額が足りている＆在庫がある場合、飲み物を購入できる。");
        $V->insertMoney(new Money(1000));
        $this->assertTrue($V->canPurchase("コーラ"));

        $I->expect("投入金額が足りている＆在庫がない場合、飲み物を購入できない。");
        for ($i = 0; $i < 5; $i++) {
            $V->purchase("コーラ");
        }
        $this->assertFalse($V->canPurchase("コーラ"));

        $I->expect("存在しない飲み物は購入できない。");
        $this->assertFalse($V->canPurchase("ドクターペッパー"));
    }

    public function testGetPurchasableBeverages()
    {
        $I = $this->codeGuy;
        $V = new VendingMachine();

        $I->expect("投入金額が0円の場合は何も購入できない。");
        $this->assertCount(0, $V->getPurchasableBeverages());

        $I->expect("投入金額が100円の場合は水だけ購入できる。");
        $V->insertMoney(new Money(100));
        $beverages = $V->getPurchasableBeverages();
        $this->assertCount(1, $beverages);
        $this->assertEquals("おいしい水", $beverages[0]);

        $I->expect("投入金額が120円の場合は水とコーラだけ購入できる。");
        $V->insertMoney(new Money(10));
        $V->insertMoney(new Money(10));
        $beverages = $V->getPurchasableBeverages();
        $this->assertCount(2, $beverages);
        $this->assertEquals("コーラ", $beverages[0]);
        $this->assertEquals("おいしい水", $beverages[1]);

        $I->expect("投入金額が220円の場合は水とコーラとレッドブルを購入できる。");
        $V->insertMoney(new Money(100));
        $beverages = $V->getPurchasableBeverages();
        $this->assertCount(3, $beverages);
        $this->assertEquals("コーラ", $beverages[0]);
        $this->assertEquals("レッドブル", $beverages[1]);
        $this->assertEquals("おいしい水", $beverages[2]);
    }
}