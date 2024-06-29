<?php
$SP->renameParameter("StatusId","IsSold");
$SP->removeParameters(["LocationPartnerTypeName","LocationPartnerName","StatusName","VehicleGroupName","VehicleTypeName"]);

$q = "EXEC [SP_Sys_Report_ReportGetReport_{$ReportId}]";
$q .= $SP->SPGenerateParameters();

$SP->SPPrepare($q);

//== Sanitize ouput
$SP->addSanitation("UnitOwned",["string"]);
$SP->addSanitation("InvoiceDate",["date"]);
$SP->addSanitation("VehicleGroup",["string"]);
$SP->addSanitation("VehicleType",["string"]);
$SP->addSanitation("ColorDescription",["string"]);
$SP->addSanitation("EngineNumber",["string"]);
$SP->addSanitation("UnitLocation",["string"]);
$SP->addSanitation("GRDate",["date"]);
$SP->addSanitation("Status",["string"]);

$SP->execute();
$report = $SP->getRow();
