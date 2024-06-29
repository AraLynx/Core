<?php
    $ajax->addSanitation("post","ValueStart", ["date"]);
    $ajax->addSanitation("post","ValueEnd", ["date"]);
    $ajax->addSanitation("post","CompanyName", ["string"]);
    $ajax->addSanitation("post","BranchName", ["string"]);
    $ajax->addSanitation("post","POSName", ["string"]);
    $ajax->addSanitation("post","ReferenceNumber", ["string"]);
    $ajax->addSanitation("post","ProgramTypeId", ["int"]);
    $ajax->addSanitation("post","StatusId", ["int"]);
?>
