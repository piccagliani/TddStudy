<?php
$I = new TestGuy($scenario);
$I->wantTo('calculate batting average.');
$I->expect("PA: 749, BA: 686, H:213 => BA: 0.310");
$I->runShellCommand("php app/console tddbc:ykhm:basic 749 686 213");
$I->seeInShellOutput("Average: .310");

$I->wantTo("test make ranking.");
$I->runShellCommand("php app/console tddbc:ykhm:file tests/_data/DevMStudy/Tdd/Bc/Yokohama/ba.txt");
$I->seeInShellOutput(' 1. .369 ルナ');
$I->seeInShellOutput(' 2. .332 マートン');
$I->seeInShellOutput(' 3. .324 ブランコ');
$I->seeInShellOutput(' 4. .313 バレンティン');
$I->seeInShellOutput(' 5. .311 中村　紀洋');
$I->seeInShellOutput(' 6. .310 ロペス');
$I->seeInShellOutput(' 7. .299 村田　修一');
$I->seeInShellOutput(' 8. .298 丸　佳浩');
$I->seeInShellOutput(' 9. .294 阿部　慎之助');
$I->seeInShellOutput('10. .293 新井　貴浩');
$I->seeInShellOutput('11. .000 打手真　千');
$I->seeInShellOutput('12. ---- 二軍　落');
