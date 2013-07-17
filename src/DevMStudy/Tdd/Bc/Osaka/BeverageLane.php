<?php
namespace DevMStudy\Tdd\Bc\Osaka;

/**
 * 自動販売機内部の飲み物格納用レーン
 * Class BeverageLane
 * @package DevMStudy\Tdd\Bc\Osaka
 */
class BeverageLane extends \SplQueue
{
    /**
     * @var string このレーンに格納している飲み物の名前
     */
    private $beverageName;

    /**
     * @var int このレーンに格納している飲み物の値段
     */
    private $beveragePrice;

    public function __construct($beverageName, $beveragePrice)
    {
        $this->beverageName = $beverageName;
        $this->beveragePrice = $beveragePrice;
    }

    /**
     * このレーンに格納している飲み物の名前を取得します。
     * @return string
     */
    public function getBeverageName()
    {
        return $this->beverageName;
    }

    /**
     * このレーンに格納している飲み物の値段を取得します。
     * @return int
     */
    public function getBeveragePrice()
    {
        return $this->beveragePrice;
    }
}