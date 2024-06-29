<?php
    $ajax->addSanitation("post","PeriodeStart", ["date"]);
    $ajax->addSanitation("post","PeriodeEnd", ["date"]);
    $ajax->addSanitation("post","SparepartCode", ["string"]);
    $ajax->addSanitation("post","SparepartName", ["string"]);
?>
