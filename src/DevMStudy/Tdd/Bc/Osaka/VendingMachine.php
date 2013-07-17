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
     * 釣り銭を出力します。
     * @param int $amount
     */
    private function outputChange($amount)
    {
        echo "釣り: " . $amount . "円";
    }
}