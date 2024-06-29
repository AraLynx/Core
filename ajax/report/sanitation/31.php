<?php
    $ajax->addSanitation("post","InvoiceDateStart", ["date"]);
    $ajax->addSanitation("post","InvoiceDateEnd", ["date"]);
    $ajax->addSanitation("post","VehicleGroupId",["int"]);
    $ajax->addSanitation("post","VehicleTypeId",["int"]);
?>
