<?php
namespace DevMStudy\Tdd\Bc\Osaka;

class Cola implements Beverage
{
    public static $name = "コーラ";

    public static $price = 120;

    public function getName()
    {
        return self::$name;
    }

    public function getPrice()
    {
        return self::$price;
    }
}