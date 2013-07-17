<?php
namespace DevMStudy\Tdd\Bc\Osaka;

/**
 * 飲み物の在庫情報
 * Class BeverageStock
 * @package DevMStudy\Tdd\Bc\Osaka
 */
class BeverageStock
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $price;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @param string $name
     * @param int $price
     * @param int $quantity
     */
    public function __construct($name, $price, $quantity)
    {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

}