<?php
$I = new TestGuy($scenario);
$I->wantTo("test fizzbuzz console application");
$I->runShellCommand("php app/console tddstudy:fizzbuzz 1 100");
$I->seeInShellOutput("1\n2\nFizz\n4\nBuzz");
$I->seeInShellOutput("14\nFizzBuzz\n16");
$I->seeInShellOutput("98\nFizz\nBuzz");
$I->dontSeeInShellOutput("101");
