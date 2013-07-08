<?php
namespace DevMStudy\Tdd;
use Codeception\Util\Stub;

class FizzBuzzTest extends \Codeception\TestCase\Test
{
   /**
    * @var \CodeGuy
    */
    protected $codeGuy;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testFizzBuzzSucceed()
    {
        $I = $this->codeGuy;
        $target = new FizzBuzz();
        $fizzBuzz = $target->generate(1, 30);

        $I->expect("count(\$fizzBuzz) is 30");
        $this->assertCount(30, $fizzBuzz);

        $I->expect("1 is 1");
        $this->assertEquals(1, $fizzBuzz[0]);

        $I->expect("2 is 2");
        $this->assertEquals(2, $fizzBuzz[1]);

        $I->expect("3 is Fizz");
        $this->assertEquals("Fizz", $fizzBuzz[2]);

        $I->expect("5 is Buzz");
        $this->assertEquals("Buzz", $fizzBuzz[4]);

        $I->expect("6 is Fizz");
        $this->assertEquals("Fizz", $fizzBuzz[5]);

        $I->expect("10 is Buzz");
        $this->assertEquals("Buzz", $fizzBuzz[9]);

        $I->expect("15 is FizzBuzz");
        $this->assertEquals("FizzBuzz", $fizzBuzz[14]);

        $I->expect("16 is 16");
        $this->assertEquals(16, $fizzBuzz[15]);

        $I->expect("30 is FizzBuzz");
        $this->assertEquals("FizzBuzz", $fizzBuzz[29]);
    }

}