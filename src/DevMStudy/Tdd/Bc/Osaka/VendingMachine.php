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
    private $lane = null;

    /**
     * @var int 売上金額
     */
    private $sales = 0;

    public function __construct()
    {
        $this->lane = new BeverageLane(Cola::$name, Cola::$price);
        for ($i = 0; $i < 5; $i++) {
            $this->lane->enqueue(new Cola());
        }
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
     * @return BeverageStock
     */
    public function getBeverageStock()
    {
        return new BeverageStock(
            $this->lane->getBeverageName(),
            $this->lane->getBeveragePrice(),
            count($this->lane)
        );
    }

    /**
     * 投入金額、在庫の点で、飲み物が購入できるかどうかを取得します。
     * @return bool
     */
    public function canPurchase()
    {
        if ($this->getTotalMoneyAmount() < $this->lane->getBeveragePrice()) {
            return false;
        }
        if (count($this->lane) === 0) {
            return false;
        }
        return true;
    }

    /**
     * 飲み物を購入します。
     * 投入金額が足りない場合もしくは在庫がない場合、購入操作を行っても何もしません。
     * @return Beverage
     */
    public function purchase()
    {
        if ($this->canPurchase() === false) {
            return NULL;
        }

        $this->totalMoneyAmount -= $this->lane->getBeveragePrice();
        $this->sales += $this->lane->getBeveragePrice();
        return $this->lane->dequeue();
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
}