<?php
    $ajax->addSanitation("post","VehicleGroupId", ["int"]);
    $ajax->addSanitation("post","VehicleTypeId", ["int"]);
    $ajax->addSanitation("post","UnitColorDescription", ["string"]);
    $ajax->addSanitation("post","Status", ["string"]);
    $ajax->addSanitation("post","UnitVIN", ["string"]);
    $ajax->addSanitation("post","UnitEngineNumber", ["string"]);
    $ajax->addSanitation("post","UnitYear", ["int"]);
    $ajax->addSanitation("post","AgeMinimum", ["int"]);
?>
