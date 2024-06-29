<?php
$SP->removeParameters(["ReferenceTypeName","MethodName","VehicleGroupName","VehicleTypeName"]);

$q = "EXEC [SP_Sys_Report_ReportGetReport_{$ReportId}]";
$q .= $SP->SPGenerateParameters();
$data = $q;
$SP->SPPrepare($q);

$SP->setReturnColumns(["TglDokumen","TglJurnal","Kendaraan","Keterangan","Method","Nominal","Divisi","PICSales","NomorReferensi",
"NomorSistem","NomorCetakan","Penyetor","PelangganNama","PelangganNo","Cabang"]);

//Sanitasi semua yang keluar di kendogrid
$SP->addSanitation("TglDokumen", ["date"]);
$SP->addSanitation("TglJurnal", ["date"]);
$SP->addSanitation("Kendaraan", ["String"]);
$SP->addSanitation("Keterangan", ["String"]);
$SP->addSanitation("Method", ["String"]);
$SP->addSanitation("Nominal", ["int"]);
$SP->addSanitation("Divisi", ["String"]);
$SP->addSanitation("PICSales", ["String"]);
$SP->addSanitation("NomorReferensi", ["String"]);
$SP->addSanitation("NomorSistem", ["String"]);
$SP->addSanitation("NomorCetakan", ["String"]);
$SP->addSanitation("Penyetor", ["String"]);
$SP->addSanitation("PelangganNama", ["String"]);
$SP->addSanitation("PelangganNo", ["string"]);
$SP->addSanitation("Cabang", ["string"]);

$SP->execute();
$report = $SP->getRow();
