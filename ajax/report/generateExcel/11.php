<?php
$headerInfos["Periode Nota"] = "{$ajax->getPost("PKBCompleteDateStart")} s/d {$ajax->getPost("PKBCompleteDateEnd")}";

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
        ->map([["BranchAlias","POSName"],"POS / Outlet"],["glue" => ", "])
        ->map(["CompleteDateTime","Tanggal"], ["formatCell" => "dateTime"])
        ->map(["PKBNumberText","No Transaksi"])
        ->map(["Type","Tipe (WalkIn/DMS/BIB)"])

        ->map(["VehiclePoliceNumber","No Polisi"], ["replace" => ["_",""]])
        ->map(["SrvNonOPLDPP","Jasa Non OPL"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["SrvOPLDPP","Jasa OPL"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["SpGenuineDPP","Part Genuine"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["SpBahanDPP","Part Bahan"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["SpCostHPP","Bahan Pembantu"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["SpLainDPP","Part Lokal"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["SpOPLDPP","Part OPL"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["VehicleVIN","No Rangka"])
        ->map(["VehicleEngineNumber","No Mesin"])
        ->map([["CustomerTitle","CustomerName"],"Customer"], ["glue" => " "])
        ->renderData()
        ->autoSize()
        ->end()
        ->getFileLink();
