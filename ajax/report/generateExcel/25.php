<?php
$tryHeaderInfos["LocationPartnerTypeName"] = "Location Type";
$tryHeaderInfos["LocationPartnerName"] = "Location Name";
$tryHeaderInfos["StatusName"] = "Status";
$tryHeaderInfos["VehicleGroupName"] = "Vehicle Group";
$tryHeaderInfos["VehicleTypeName"] = "Vehicle Type";

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
    ->map(["UnitOwned","Kepemilikan"])
    ->map(["InvoiceDate","Tanggal DO"],["formatCell" => "date"])
    ->map([["VehicleGroup","VehicleType"],"Tipe Kendaraan"])
    ->map(["ColorDescription","Warna"])
    ->map(["EngineNumber","No Mesin"])
    ->map(["UnitLocation","Lokasi"])
    ->map(["GRDate","Tanggal Masuk"],["formatCell" => "date"])
    ->map("Status")
    ->renderData()
    ->autoSize()
    ->end()
    ->getFileLink();
