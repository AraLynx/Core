<?php

$q = "EXEC [SP_Sys_Report_ReportGetReport_{$ReportId}]";
$q .= $SP->SPGenerateParameters();
//$data = $q;
$SP->SPPrepare($q);

$SP->execute();
$rows = $SP->getRow();

$LastIO = "";
foreach($rows AS $index => $row)
{
    $NowIO = $row["InvoiceHeaderDocumentNumber"];
    if($LastIO != $NowIO) $Number = 1;
    else $Number++;

    $rows[$index]["Number"] = $Number;
    $LastIO = $NowIO;
}
$report = $rows;
