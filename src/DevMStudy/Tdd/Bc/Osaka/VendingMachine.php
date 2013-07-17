<?php
namespace DevMStudy\Tdd\Bc\Osaka;

class VendingMachine
{
    private $totalMoneyAmount = 0;

    /**
     * お金を入金します。
     */
    public function insertMoney(Money $money)
    {
        $this->totalMoneyAmount += $money->getAmount();
    }

    /**
     * 入金額の総計を取得します。
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
        echo "釣り: " . $this->getTotalMoneyAmount() . "円";
        $this->totalMoneyAmount = 0;
    }
}