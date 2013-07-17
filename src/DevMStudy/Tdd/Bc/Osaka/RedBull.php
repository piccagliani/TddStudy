<?php
namespace DevMStudy\Tdd\Bc\Osaka;

class RedBull implements Beverage
{
    public static $name = "レッドブル";

    public static $price = 200;

    public function getName()
    {
        return self::$name;
    }

    public function getPrice()
    {
        return self::$price;
    }
}