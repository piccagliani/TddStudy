<?php
namespace DevMStudy\Tdd\Bc\Osaka;

/**
 * お金クラス
 * Class Money
 * @package DevMStudy\Tdd\Bc\Osaka
 */
class Money
{
    private $amount;

    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    public function getAmount()
    {
        return $this->amount;
    }
}