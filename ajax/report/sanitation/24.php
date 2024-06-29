<?php
    $ajax->addSanitation("post","DateType",["int"]);
    $ajax->addSanitation("post","DateStart",["Date"]);
    $ajax->addSanitation("post","DateEnd",["Date"]);

    $ajax->addSanitation("post","NumberType",["int"]);
    $ajax->addSanitation("post","NumberValue",["string"]);

    $ajax->addSanitation("post","FromType",["int"]);
    $ajax->addSanitation("post","FromValue",["string"]);

    $ajax->addSanitation("post","ReferenceTypeId",["int"]);
    $ajax->addSanitation("post","MethodId",["string"]);
    $ajax->addSanitation("post","VehicleGroupId",["int"]);
    $ajax->addSanitation("post","VehicleTypeId",["int"]);
    $ajax->addSanitation("post","PICSales",["string"]);
?>
