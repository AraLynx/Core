<?php
$headerInfos["Periode Nota"] = $ajax->getPost("CompleteDateStart")." s/d ".$ajax->getPost("CompleteDateEnd");

if($ajax->getPost("SalesMethod") != "*")
{
    $SalesMethod = $ajax->getPost("SalesMethod");
    if($SalesMethod == "IsCash")$headerInfos["Metode Jual"] = "CASH";
    if($SalesMethod == "IsCredit")$headerInfos["Metode Jual"] = "CREDIT";
}

$tryHeaderInfos["VehicleGroupName"] = "Vehicle Group";
$tryHeaderInfos["VehicleTypeName"] = "Vehicle Type";
$tryHeaderInfos["UnitColor"] = "Warna";
$tryHeaderInfos["UnitEngineNumber"] = "No Mesin";
$tryHeaderInfos["UnitVIN"] = "No Rangka";
$tryHeaderInfos["UnitYear"] = "Thn Rangka";

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

$datas["post"] = $ajax->getPost();

$datas["FileLink"] = $spreadSheet->map(["CompleteDateTime","Tgl Nota"])
    ->map(["POSName","POS / Outlet"])
    ->map(["NumberText","No SPK"])
    ->map(["SalesMethod","Metode Jual"])
    ->map(["LeasingVendorName","Nama Leasing"])
    ->map(["CustomerName","Nama Konsumen"])
    ->map([["VehicleGroupName","VehicleTypeName"],"Tipe Kendaraan"])
    ->map(["UnitEngineNumber","No Mesin"])
    ->map(["OTRPrice","Nilai AR"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->map([["TeamLeaderEmployeeId","TeamLeaderEmployeeName", "TeamLeaderEmployeeGroupName"],"Team Leader"])
    ->renderData()
    ->autoSize()
    ->end()
    ->getFileLink();
