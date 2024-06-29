<?php
$ajax->addSanitation("post","DateStart", ["date"]);
$ajax->addSanitation("post","DateEnd", ["date"]);
$ajax->addSanitation("post","SPKNumber", ["string"]);
$ajax->addSanitation("post","DocumentNumber", ["string"]);
$ajax->addSanitation("post","ReferenceNumber", ["string"]);
?>
