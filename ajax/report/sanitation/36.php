<?php
    $ajax->addSanitation("post","GRDateStart",["date"]);
    $ajax->addSanitation("post","GRDateEnd",["date"]);
    $ajax->addSanitation("post","CaroserieNumber",["string"]);
    $ajax->addSanitation("post","PONumber",["string"]);
    $ajax->addSanitation("post","UnitIdentityType",["string"]);
    $ajax->addSanitation("post","UnitIdentityValue",["string"]);
?>