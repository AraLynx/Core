<?php
$q = "EXEC [SP_Sys_Report_ReportGetReport_{$ReportId}]";
$q .= $SP->SPGenerateParameters();
//$data = $q;
$SP->SPPrepare($q);

$SP->addSanitation("Id",["int"]);
$SP->addSanitation("Code",["string"]);
$SP->addSanitation("Name",["string"]);
$SP->addSanitation("Balance",["decimal"]);
$SP->execute();
$Summary = [];
foreach($SP->getRow() AS $row)
{
    $Summary[$row["Id"]] = $row;
    $Summary[$row["Id"]]["Items"] = [];
}

$SP->addSanitation("No",["int"]);
$SP->addSanitation("COA6Id",["int"]);
$SP->addSanitation("DateTime",["dateTime"]);
$SP->addSanitation("ReferenceNumber",["string"]);
$SP->addSanitation("Description",["string"]);
$SP->addSanitation("Debit",["decimal"]);
$SP->addSanitation("Credit",["decimal"]);
$SP->addSanitation("Balance",["decimal"]);
$SP->nextRowset();
foreach($SP->getRow() AS $row)
{
    $Summary[$row["COA6Id"]]["Items"][] = $row;
}

foreach($Summary AS $COA6Id => $data)
{
    $report[] = $data;
}
