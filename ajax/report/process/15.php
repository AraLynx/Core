<?php
$q = "EXEC [SP_Sys_Report_ReportGetReport_{$ReportId}]";
$q .= $SP->SPGenerateParameters();
//$data = $q;
$SP->SPPrepare($q);

//$data = $q;
// $SP->addSanitation("CBPName", ["string"]);
$SP->addSanitation("NumberText", ["string"]);
$SP->addSanitation("DSDate", ["date"]);
$SP->addSanitation("Customer", ["string"]);
$SP->addSanitation("Sparepart", ["int"]);
$SP->execute();
$report = $SP->getRow();
