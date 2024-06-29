<?php
$headerInfos["Periode Nota"] = "{$ajax->getPost("DateStart")} s/d {$ajax->getPost("DateEnd")}";
$headerInfos["Divisi"] = $ajax->getPost("ReferenceTypeName");
$headerInfos["Method"] = $ajax->getPost("MethodName");

$desc = "";
if($ajax->getPost("DocumentField") == "1")$desc = "Print Number";
if($ajax->getPost("DocumentField") == "2")$desc = "Document Number";
if($ajax->getPost("DocumentField") == "3")$desc = "Reference Number";
if($desc)$headerInfos[$desc] = $ajax->getPost("DocumentValue");

$desc = "";
if($ajax->getPost("CustomerField") == "1")$desc = "Customer Name";
if($ajax->getPost("CustomerField") == "2")$desc = "Depositor";
if($desc)$headerInfos[$desc] = $ajax->getPost("CustomerValue");

$tryHeaderInfos["VehicleGroupName"] = "Vehicle Group";
$tryHeaderInfos["VehicleTypeName"] = "Vehicle Type";
$tryHeaderInfos["PICSales"] = "PIC Sales";

foreach($tryHeaderInfos AS $inputName => $description)
{
    if($ajax->getPost($inputName))
        $headerInfos[$description] = $ajax->getPost($inputName);
}

$headerParams = [
    "columnIndex" => 0,
    "rowIndex" => 1,
    "titleText" => $reportDescription,
    "mergeCellCount" => 5,
    "infos" => $headerInfos,
];
$spreadSheet->generateHeader($headerParams);

$datas["FileLink"] = $spreadSheet
    ->map(["Cabang","Cabang"])
->startHeaderGroup("Pelanggan")
    ->map(["PelangganNo","Nomor"])
    ->map(["PelangganNama","Nama"])
->endHeaderGroup()
    ->map(["Penyetor","Penyetor"])
->startHeaderGroup("Nomor")
    ->map(["NomorCetakan","Cetakan"])
    ->map(["NomorSistem","Dokumen"])
    ->map(["NomorReferensi","Referensi"])
    ->endHeaderGroup()
    ->map(["PICSales","PIC Sales"])
    ->map(["Divisi","Divisi"])
->startHeaderGroup("Tanggal")
    ->map(["TglDokumen","Dokumen"])
    ->map(["TglJurnal","Jurnal"])
->endHeaderGroup()
    ->map(["Kendaraan","Kendaraan"])
    ->map(["Keterangan","Keterangan"])
    ->map(["Method","Metode"])
    ->map(["Nominal","Nominal"],["formatCell" => "currency", "aggregate" => "sum"])
->renderData()
->autoSize()
->end()
->getFileLink();
