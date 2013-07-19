<?php
namespace Codeception\Module;

// here you can define custom functions for CodeGuy 

class CodeHelper extends \Codeception\Module
{
    public function seeInStandardOutput($expect, \Closure $func)
    {
        ob_start();
        ob_implicit_flush(false);
        $result = $func();
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertContains($expect, $output);
        return $result;
    }
}
