<?php

$q = "EXEC [SP_Sys_Report_ReportGetReport_{$ReportId}]";
$q .= $SP->SPGenerateParameters();
//$data = $q;
$SP->SPPrepare($q);

$SP->execute();
$rows = $SP->getRow();

$LastPS = "";
foreach($rows AS $index => $row)
{
    $NowPS = $row["PSNumberText"];
    if($LastPS != $NowPS) $Number = 1;
    else $Number++;

    $rows[$index]["Number"] = $Number;
    $LastPS = $NowPS;
}
$report = $rows;
