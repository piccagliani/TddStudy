<?php
namespace DevMStudy\Tdd\Bc\Osaka;

class Water
{
    public static $name = "おいしい水";

    public static $price = 100;

    public function getName()
    {
        return self::$name;
    }

    public function getPrice()
    {
        return self::$price;
    }
}