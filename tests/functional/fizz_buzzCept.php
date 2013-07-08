<?php
$I = new TestGuy($scenario);
$I->wantTo("test app/fizz_buzz.php");
$I->runShellCommmand("php app/fizz_buzz.php");
$I->seeInShellOutput("1\n2\nFizz\n4\nBuzz");
$I->seeInShellOutput("14\nFizzBuzz\n16");
$I->seeInShellOutput("98\nFizz\nBuzz");
$I->dontSeeInShellOutput("101");
