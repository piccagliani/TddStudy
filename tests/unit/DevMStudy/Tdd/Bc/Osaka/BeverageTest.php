<?php
namespace DevMStudy\Tdd\Bc\Osaka;
use Codeception\Util\Stub;

class BeverageTest extends \Codeception\TestCase\Test
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
    public function testCola()
    {
        $I = $this->codeGuy;

        $I->expect("コーラは120円");
        $cola = new Cola();
        $this->assertEquals("コーラ", $cola->getName());
        $this->assertEquals(120, $cola->getPrice());
    }

}