<?php
$tryHeaderInfos["VehicleGroupName"] = "Vehicle Group";
$tryHeaderInfos["VehicleTypeName"] = "Vehicle Type";
$tryHeaderInfos["StatusName"] = "Status";

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
    ->map(["GRDate","Tanggal Masuk"],["formatCell" => "date"])
    ->map(["InvoiceDate","Tanggal DO"],["formatCell" => "date"])
    ->map(["BranchName","Cabang"])
    ->map([["VehicleGroup","VehicleType"],"Tipe Kendaraan"])
    ->map(["ColorDescription","Warna"])
    ->map(["EngineNumber","No Mesin"])
    ->map("Status")
    ->renderData()
    ->autoSize()
    ->end()
    ->getFileLink();
