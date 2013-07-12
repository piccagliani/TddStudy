<?php
$I = new TestGuy($scenario);
$I->wantTo('calculate batting average.');

$I->expectTo("show usage with no arguments");
$I->runShellCommmand("php app/ba_calc.php");
$I->seeInShellOutput("Usage");

$I->expectTo("show usage with 1 arguments");
$I->runShellCommmand("php app/ba_calc.php 749");
$I->seeInShellOutput("Usage");

$I->expectTo("show usage with 2 arguments");
$I->runShellCommmand("php app/ba_calc.php 749 686");
$I->seeInShellOutput("Usage");

$I->expectTo("show usage with 4 arguments");
$I->runShellCommmand("php app/ba_calc.php 749 686 213 1");
$I->seeInShellOutput("Usage");

$I->expect("PA: 749, BA: 686, H:213 => BA: 0.310");
$I->runShellCommmand("php app/ba_calc.php 749 686 213");
$I->seeInShellOutput("Average: 0.310");
