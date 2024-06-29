<?php
    $ajax->addSanitation("post","LocationPartnerTypeId",["int"]);
    $ajax->addSanitation("post","LocationPartnerId",["int"]);
    $ajax->addSanitation("post","StatusId", ["allowEmpty"]);
    $ajax->addSanitation("post","VehicleBrandId",["int"]);
    $ajax->addSanitation("post","VehicleGroupId",["int"]);
    $ajax->addSanitation("post","VehicleTypeId",["int"]);
?>
