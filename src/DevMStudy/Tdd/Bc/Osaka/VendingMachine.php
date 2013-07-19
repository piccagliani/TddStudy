<?php
namespace DevMStudy\Tdd\Bc\Osaka;

/**
 * 飲み物自動販売機 Ver 2.0
 * Class VendingMachine
 * @package DevMStudy\Tdd\Bc\Osaka
 * @see http://devtesting.jp/tddbc/?TDDBC%E5%A4%A7%E9%98%AA3.0%2F%E8%AA%B2%E9%A1%8C
 */
class VendingMachine
{
    /**
     * @var int 入金総額
     */
    private $totalMoneyAmount = 0;

    /**
     * @var array 入金可能額
     */
    private $availableMoneyAmount = [10, 50, 100, 500, 1000];

    /**
     * @var BeverageLane 飲み物格納レーン
     */
    private $lanes = [];

    /**
     * @var int 売上金額
     */
    private $sales = 0;

    public function __construct()
    {
        $colaLane = new BeverageLane(Cola::$name, Cola::$price);
        $redBullLane = new BeverageLane(RedBull::$name, RedBull::$price);
        $waterLane = new BeverageLane(Water::$name, Water::$price);
        for ($i = 0; $i < 5; $i++) {
            $colaLane->enqueue(new Cola());
            $redBullLane->enqueue(new RedBull());
            $waterLane->enqueue(new Water());
        }
        $this->lanes[] = $colaLane;
        $this->lanes[] = $redBullLane;
        $this->lanes[] = $waterLane;
    }

    /**
     * 入金します。
     * 想定外のもの（硬貨：１円玉、５円玉。お札：千円札以外のお札）が投入された場合は、
     * 投入金額に加算せず、それをそのまま釣り銭としてユーザに出力します。
     * @param Money $money
     */
    public function insertMoney(Money $money)
    {
        $amount = $money->getAmount();
        if (in_array($amount, $this->availableMoneyAmount)) {
            $this->totalMoneyAmount += $amount;
        } else {
            $this->outputChange($amount);
        }
    }

    /**
     * 入金総額を取得します。
     * @return int
     */
    public function getTotalMoneyAmount()
    {
        return $this->totalMoneyAmount;
    }

    /**
     * 払い戻します。
     */
    public function payBack()
    {
        $this->outputChange($this->totalMoneyAmount);
        $this->totalMoneyAmount = 0;
    }

    /**
     * 飲み物の情報（値段と名前と在庫）を取得します。
     * @return array
     */
    public function getBeverageStocks()
    {
        $stocks = [];
        foreach ($this->lanes as $lane) {
            $stocks[] = new BeverageStock(
                $lane->getBeverageName(),
                $lane->getBeveragePrice(),
                count($lane)
            );
        }
        return $stocks;
    }

    /**
     * 投入金額、在庫の点で購入可能な飲み物のリストを取得できる。
     * @return array
     */
    public function getPurchasableBeverages()
    {
        $purchasable = [];
        foreach ($this->lanes as $lane) {
            /** @var BeverageLane $lane */
            if ($lane->canPurchase($this->totalMoneyAmount)) {
                $purchasable[] = $lane->getBeverageName();
            }
        }
        return $purchasable;
    }

    /**
     * 投入金額、在庫の点で、飲み物が購入できるかどうかを取得します。
     * @param string $name
     * @return bool
     */
    public function canPurchase($name)
    {
        $lane = $this->getLaneFor($name);
        if ($lane === null) {
            return false;
        }

        return $lane->canPurchase($this->totalMoneyAmount);
    }

    /**
     * 飲み物を購入します。
     * 購入操作を行うと、釣り銭（投入金額とジュース値段の差分）を出力します。
     * 投入金額が足りない場合もしくは在庫がない場合、購入操作を行っても何もしません。
     * @param $name
     * @return Beverage
     */
    public function purchase($name)
    {
        if ($this->canPurchase($name) === false) {
            return;
        }

        $lane = $this->getLaneFor($name);
        $price = $lane->getBeveragePrice();
        $lane->dequeue();
        $this->totalMoneyAmount -= $price;
        $this->sales += $price;
        $this->payBack();
    }

    /**
     * 売上金額を取得します。
     */
    public function getSales()
    {
        return $this->sales;
    }

    /**
     * 釣り銭を出力します。
     * @param int $amount
     */
    private function outputChange($amount)
    {
        echo "釣り: " . $amount . "円";
    }

    /**
     * 引数で指定された飲み物を格納しているレーンを取得します。
     * @param $name
     * @return \DevMStudy\Tdd\Bc\Osaka\BeverageLane|null
     */
    private function getLaneFor($name)
    {
        foreach ($this->lanes as $lane) {
            /** @var BeverageLane $lane */
            if ($lane->getBeverageName() === $name) {
                return $lane;
            }
        }
        return null;
    }
}