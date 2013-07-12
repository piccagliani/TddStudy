<?php
namespace DevMStudy\Tdd\FizzBuzz;

class FizzBuzzGenerator
{
    public function generate($start, $end)
    {
        $fizzBuzz = [];
        for ($i = $start; $i <= $end; $i++) {
            if ($i % 15 === 0) {
                $fizzBuzz[] = "FizzBuzz";
            } else if ($i % 3 === 0) {
                $fizzBuzz[] = "Fizz";
            } else if ($i % 5 === 0) {
                $fizzBuzz[] = "Buzz";
            } else {
                $fizzBuzz[] = $i;
            }
        }
        return $fizzBuzz;
    }
}