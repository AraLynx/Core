<?php
$q = "EXEC [SP_Sys_Report_ReportGetReport_{$ReportId}]";
$q .= $SP->SPGenerateParameters();
//$data = $q;
$SP->SPPrepare($q);

$SP->addSanitation("SpPOSId", ["int"]);
$SP->addSanitation("CompanyName", ["string"]);
$SP->addSanitation("BranchAlias", ["string"]);
$SP->addSanitation("POSName", ["string"]);
$SP->addSanitation("SparepartCode", ["string"]);
$SP->addSanitation("SparepartName", ["string"]);
$SP->addSanitation("S", ["dec"]);
$SP->addSanitation("GR", ["dec"]);
$SP->addSanitation("GI", ["dec"]);
$SP->addSanitation("GIX", ["dec"]);
$SP->addSanitation("MTO", ["dec"]);
$SP->addSanitation("MTOX", ["dec"]);
$SP->addSanitation("MTOR", ["dec"]);
$SP->addSanitation("MTI", ["dec"]);
$SP->addSanitation("ADJ", ["dec"]);
$SP->addSanitation("E", ["dec"]);
$SP->execute();
$report = $SP->getRow();
