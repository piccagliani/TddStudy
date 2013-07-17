<?php
namespace Codeception\Module;

// here you can define custom functions for CodeGuy 

class CodeHelper extends \Codeception\Module
{
    public function getOutputString(\Closure $func)
    {
        ob_start();
        ob_implicit_flush(false);
        $func();
        $string = ob_get_contents();
        ob_end_clean();
        return $string;
    }
}
