<?php
namespace DevMStudy\Tdd\FizzBuzz;

use Codeception\Util\Stub;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class ConsoleCommandTest extends \Codeception\TestCase\Test
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
    public function testConsoleCommand()
    {
        $I = $this->codeGuy;
        $command = new ConsoleCommand();

        $I->expect("Exception to be thrown if 'start' is not integer.");
        try {
            $input = new ArrayInput(["start" => "a", "end" => 100]);
            $output = new NullOutput();
            $command->run($input, $output);
            $this->fail();
        } catch (\Exception $e) {
            $this->assertEquals('"start" must be integer.', $e->getMessage());
        }

        $I->expect("Exception to be thrown if 'end' is not integer.");
        try {
            $input = new ArrayInput(["start" => 1, "end" => "a"]);
            $output = new NullOutput();
            $command->run($input, $output);
            $this->fail();
        } catch (\Exception $e) {
            $this->assertEquals('"end" must be integer.', $e->getMessage());
        }

        $I->expect("Exception to be thrown if 'start' is larger than 'end'.");
        try {
            $input = new ArrayInput(["start" => 100, "end" => 1]);
            $output = new NullOutput();
            $command->run($input, $output);
            $this->fail();
        } catch (\Exception $e) {
            $this->assertEquals('"start" must be smaller than "end".', $e->getMessage());
        }

        try {
            $input = new ArrayInput(["start" => 1, "end" => 100]);
            $output = new NullOutput();
            $command->run($input, $output);
        } catch (\Exception $e) {
            $this->fail("exception occurred");
        }
    }
}
