<?php
$SP->renameParameter("DivisionId","Division");
$SP->renameParameter("StatusId","Status");

$SP->removeParameters(["ReportVersion","StatusName","VehicleGroupName","VehicleTypeName"]);

$q = "EXEC [SP_Sys_Report_ReportGetReport_{$ReportId}]";
$q .= $SP->SPGenerateParameters();
$data = $q;
$SP->SPPrepare($q);

//== Sanitize ouput
$SP->addSanitation("SPKId",["int"]);
$SP->addSanitation("SPKNo",["string"]);
$SP->addSanitation("RegisterDate",["date"]);
$SP->addSanitation("DistributionDate",["date"]);
$SP->addSanitation("SPKNoText",["string"]);
$SP->addSanitation("SPKDate",["date"]);

$SP->addSanitation("POSName",["string"]);
$SP->addSanitation("TeamLeaderNIK",["string"]);
$SP->addSanitation("TeamLeaderName",["string"]);
$SP->addSanitation("Status",["string"]);

$SP->addSanitation("InvoiceNoText",["string"]);
$SP->addSanitation("InvoiceDate",["date"]);

$SP->addSanitation("PelangganNo",["string"]);
$SP->addSanitation("PelangganPanggilan",["string"]);
$SP->addSanitation("PelangganNama",["string"]);
$SP->addSanitation("PelangganAlamat1",["string"]);
$SP->addSanitation("PelangganAlamat2",["string"]);
$SP->addSanitation("PelangganAlamatRT",["string"]);
$SP->addSanitation("PelangganAlamatRW",["string"]);
$SP->addSanitation("PelangganAlamatKodePos",["string"]);
$SP->addSanitation("PelangganAlamatPropinsi",["string"]);
$SP->addSanitation("PelangganAlamatKabupaten",["string"]);
$SP->addSanitation("PelangganAlamatKecamatan",["string"]);
$SP->addSanitation("PelangganAlamatKelurahan",["string"]);

$SP->addSanitation("MaterialCode",["string"]);
$SP->addSanitation("VehicleGroup",["string"]);
$SP->addSanitation("VehicleType",["string"]);
$SP->addSanitation("UnitColor",["string"]);

$SP->addSanitation("STNKPanggilan",["string"]);
$SP->addSanitation("STNKNama",["string"]);
$SP->addSanitation("STNKAlamat1",["string"]);
$SP->addSanitation("STNKAlamat2",["string"]);
$SP->addSanitation("STNKAlamatRT",["string"]);
$SP->addSanitation("STNKAlamatRW",["string"]);
$SP->addSanitation("STNKAlamatKodePos",["string"]);
$SP->addSanitation("STNKAlamatPropinsi",["string"]);
$SP->addSanitation("STNKAlamatKabupaten",["string"]);
$SP->addSanitation("STNKAlamatKecamatan",["string"]);
$SP->addSanitation("STNKAlamatKelurahan",["string"]);

$SP->addSanitation("SalesNIK",["string"]);
$SP->addSanitation("SalesNama",["string"]);
$SP->addSanitation("NilaiJual",["int"]);

$SP->execute();
$report = $SP->getRow();
