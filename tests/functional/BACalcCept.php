<?php
$I = new TestGuy($scenario);
$I->wantTo('calculate batting average.');
$I->expect("PA: 749, BA: 686, H:213 => BA: 0.310");
$I->runShellCommmand("php app/console tddbc:ykhm:basic 749 686 213");
$I->seeInShellOutput("Average: .310");
