<?php
require_once __DIR__ . "/../vendor/autoload.php";

$generator = new DevMStudy\Tdd\FizzBuzz();
$fizzBuzz = $generator->generate(1, 100);
foreach($fizzBuzz as $line) {
    echo $line."\n";
}
