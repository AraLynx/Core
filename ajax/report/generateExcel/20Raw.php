<?php
$headerInfos["Periode"] = $ajax->getPost("PeriodeStart")." s/d ".$ajax->getPost("PeriodeEnd");
$tryHeaderInfos["VehicleGroupName"] = "Group";
$tryHeaderInfos["VehicleTypeName"] = "Type";
$tryHeaderInfos["SparepartCode"] = "Code";
$tryHeaderInfos["SparepartName"] = "Sparepart";

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

$datas["FileLink"] = $spreadSheet->map(["POSName","POS / Outlet"])
        ->map(["SparepartCode","Code"])
        ->map(["SparepartName","Sparepart"])

        ->map(["DateTime","Date & Time"], ["formatCell" => "dateTime"])
        ->map(["TransactionName", "Transaction"])
        ->map(["ReferenceNumber", "Reference Number"])
        ->map("Quantity", ["formatCell" => "dec1"])

        ->renderData()
        ->autoSize()
        ->end()
        ->getFileLink();
