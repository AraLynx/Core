<?php
$headerInfos["DO Date"] = "{$ajax->getPost("InvoiceDateStart")} s/d {$ajax->getPost("InvoiceDateEnd")}";
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
        ->map(["InvoiceNumber","No Invoice"])
        ->map(["InvoiceDate","Invoice Date"])
        ->map("Cabang")
        ->map(["VehicleGroup","Type"])
        ->map(["VehicleTypeAll","Suffix"])
        ->map("RRN")
        ->map(["VIN","No Rangka"])
        ->map(["EngineNumber","No Mesin"])
        ->map(["ColorDescription","Warna"])
        ->map(["Quantity","QTY"])
        ->renderData()
        ->autoSize()
        ->end()
        ->getFileLink();
