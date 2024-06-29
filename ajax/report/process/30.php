<?php
$param = $ajax->getPost("Field");
$value = $ajax->getPost("Value");
$SP->addParameter($param, $value);

$SP->removeParameters(["Field","Value"]);

$q = "EXEC [SP_Sys_Report_ReportGetReport_{$ReportId}]";
$q .= $SP->SPGenerateParameters();
//$data = $q;
$SP->SPPrepare($q);

//Sanitasi semua yang keluar di kendogrid
$SP->addSanitation("DateTime", ["dateTime"]);

$SP->execute();

$isSold = 0;
foreach($SP->getRow() AS $index => $row)
{
    if($row["TransactionName"] == "NOTA")
    {
        $isSold = 1;
    }

    if($isSold)
    {
        $row["Status"] = "SOLD";
        $row["RowClass"] = "text-success fw-bold";
    }
    else
    {
        $row["Status"] = "ON HAND";
    }

    $report[] = $row;
}
