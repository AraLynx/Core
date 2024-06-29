<?php
$SP->renameParameter("StatusId","IsSoldId");
$SP->removeParameters(["VehicleGroupName","VehicleTypeName","StatusName"]);

$q = "EXEC [SP_Sys_Report_ReportGetReport_{$ReportId}]";
$q .= $SP->SPGenerateParameters();

$SP->SPPrepare($q);

//== Sanitize ouput
$SP->addSanitation("GRDate",["date"]);
$SP->addSanitation("InvoiceDate",["date"]);
$SP->addSanitation("BranchName",["string"]);
$SP->addSanitation("VehicleGroup",["string"]);
$SP->addSanitation("VehicleType",["string"]);
$SP->addSanitation("ColorDescription",["string"]);
$SP->addSanitation("EngineNumber",["String"]);
$SP->addSanitation("Status",["string"]);

$SP->execute();
$report = $SP->getRow();
