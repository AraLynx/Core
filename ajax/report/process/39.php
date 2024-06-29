<?php
$q = "EXEC [SP_Sys_Report_ReportGetReport_{$ReportId}]";
$q .= $SP->SPGenerateParameters();
//$data = $q;
$SP->SPPrepare($q);
$SP->execute();
$report = $SP->getRow();

$PKBSparepartCostCounter = 1;
$LastPKBId = 0;
foreach($report AS $key => $row)
{
    $PKBId = $row["Id"];
    if($LastPKBId == $PKBId)$PKBSparepartCostCounter++;
    else $PKBSparepartCostCounter = 1;

    $report[$key]["PKBSparepartCostCounter"] = $PKBSparepartCostCounter;
    $report[$key]["VehiclePoliceNumber"] = str_replace("_","",$row["VehiclePoliceNumber"]);

    $LastPKBId = $PKBId;
}
