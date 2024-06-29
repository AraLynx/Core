<?php

$q = "EXEC [SP_Sys_Report_ReportGetReport_{$ReportId}]";
$q .= $SP->SPGenerateParameters();
//$data = $q;
$SP->SPPrepare($q);

$SP->addSanitation("PosName", ["string"]);
$SP->addSanitation("SparepartCode", ["string"]);
$SP->addSanitation("SparepartName", ["string"]);
$SP->addSanitation("DateTime", ["dateTime"]);
$SP->addSanitation("TransactionName", ["string"]);
$SP->addSanitation("ReferenceNumber", ["string"]);
$SP->addSanitation("Quantity", ["dec"]);
$SP->execute();
$report = $SP->getRow();
