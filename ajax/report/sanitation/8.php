<?php
$ajax->addSanitation("post","DepositDateStart", ["date"]);
$ajax->addSanitation("post","DepositDateEnd", ["date"]);
$ajax->addSanitation("post","VINNumber", ["string"]);
$ajax->addSanitation("post","EngineNumber", ["string"]);
$ajax->addSanitation("post","SPKNumber", ["string"]);
$ajax->addSanitation("post","CustomerName", ["string"]);
$ajax->addSanitation("post","STNKName", ["string"]);
?>
