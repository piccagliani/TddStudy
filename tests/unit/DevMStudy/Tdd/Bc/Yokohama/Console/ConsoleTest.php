<?php
namespace DevMStudy\Tdd\Bc\Yokohama\Console;

use Codeception\Configuration;
use Codeception\Util\Stub;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class BasicTest extends \Codeception\TestCase\Test
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
    public function testBasic()
    {
        $I = $this->codeGuy;
        $command = new Basic();

        $I->expect("Exception to be thrown if 'PA' is not integer.");
        try {
            $input = new ArrayInput(["AB" => "a", "PA" => 686, "H" => 213]);
            $output = new NullOutput();
            $command->run($input, $output);
            $this->fail();
        } catch (\Exception $e) {
            $this->assertEquals('"AB" must be integer.', $e->getMessage());
        }

        $I->expect("Exception to be thrown if 'AB' is not integer.");
        try {
            $input = new ArrayInput(["AB" => 749, "PA" => "a", "H" => 213]);
            $output = new NullOutput();
            $command->run($input, $output);
            $this->fail();
        } catch (\Exception $e) {
            $this->assertEquals('"PA" must be integer.', $e->getMessage());
        }

        $I->expect("Exception to be thrown if 'H' is not integer.");
        try {
            $input = new ArrayInput(["AB" => 749, "PA" => 686, "H" => "a"]);
            $output = new NullOutput();
            $command->run($input, $output);
            $this->fail();
        } catch (\Exception $e) {
            $this->assertEquals('"H" must be integer.', $e->getMessage());
        }

        try {
            $input = new ArrayInput(["AB" => 749, "PA" => 686, "H" => 213]);
            $output = new NullOutput();
            $command->run($input, $output);
        } catch (\Exception $e) {
            $this->fail("exception occurred");
        }
    }

    public function testFile()
    {
        $I = $this->codeGuy;
        $command = new File();

        $I->expect("指定されたファイルが存在しない場合はExceptionが発生する");
        try {
            $input = new ArrayInput(["filename" => "notfound.txt"]);
            $output = new NullOutput();
            $command->run($input, $output);
            $this->fail();
        } catch (\Exception $e) {
            $this->assertEquals("'notfound.txt' is not found or unreadable.", $e->getMessage());
        }

        $I->expect("指定されたファイルが存在する場合はExceptionが発生しない");
        try {
            $input = new ArrayInput(["filename" => Configuration::dataDir() . "DevMStudy/Tdd/Bc/Yokohama/ba.txt"]);
            $output = new NullOutput();
            $command->run($input, $output);
        } catch (\Exception $e) {
            $this->fail();
        }
    }
}