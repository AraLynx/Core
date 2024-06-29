<?php
$q = "EXEC [SP_Sys_Report_ReportGetReport_{$ReportId}]";
$q .= $SP->SPGenerateParameters();
// $data = $q;
$SP->SPPrepare($q);

$SP->addSanitation("SPKId",["int"]);
$SP->addSanitation("Cabang",["string"]);
$SP->addSanitation("SPKNumberText",["string"]);
$SP->addSanitation("TanggalSPK",["date"]);
$SP->addSanitation("TanggalNota",["date"]);
$SP->addSanitation("NoDocument",["string"]);

$SP->addSanitation("NamaPemesan",["string"]);
$SP->addSanitation("NamaSTNK",["string"]);
$SP->addSanitation("Alamat",["string"]);
$SP->addSanitation("NoHandphone",["string"]);

$SP->addSanitation("NoRangka",["string"]);
$SP->addSanitation("NoMesin",["string"]);
$SP->addSanitation("UnitType",["string"]);

$SP->addSanitation("TipePenjualan",["string"]);
$SP->addSanitation("VendorLeasing",["string"]);

$SP->addSanitation("NamaSalesman",["string"]);
$SP->addSanitation("GradeSalesman",["string"]);
$SP->addSanitation("LeaderName",["string"]);
$SP->addSanitation("GradeLeader",["string"]);

$SP->addSanitation("CD1Date",["date"]);
$SP->addSanitation("CD1Type",["string"]);
$SP->addSanitation("CD1NoPlutus",["string"]);
$SP->addSanitation("CD1Nominal",["int"]);
$SP->addSanitation("CD1Metode",["string"]);

$SP->addSanitation("CD2Date",["date"]);
$SP->addSanitation("CD2Type",["string"]);
$SP->addSanitation("CD2NoPlutus",["string"]);
$SP->addSanitation("CD2Nominal",["int"]);
$SP->addSanitation("CD2Metode",["string"]);

$SP->addSanitation("CD3Date",["date"]);
$SP->addSanitation("CD3Type",["string"]);
$SP->addSanitation("CD3NoPlutus",["string"]);
$SP->addSanitation("CD3Nominal",["int"]);
$SP->addSanitation("CD3Metode",["string"]);

$SP->execute();
foreach($SP->getRow() AS $index => $row)
{
    $row["NoHandphone"] = str_replace(["-_","_"],"",$row["NoHandphone"]);
    $report[] = $row;
}
