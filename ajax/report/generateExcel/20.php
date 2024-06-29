<?php
$headerInfos["Periode"] = $ajax->getPost("PeriodeStart")." s/d ".$ajax->getPost("PeriodeEnd");
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

$datas["FileLink"] = $spreadSheet->map([["BranchAlias","POSName"],"POS / Outlet"],["glue" => ", "])
    ->map(["SparepartCode","Code"])
    ->map(["SparepartName","Sparepart"])

    ->map(["S","START"], ["formatCell" => "numeric"])
    ->map("GR", ["formatCell" => "numeric"])
    ->map("GI", ["formatCell" => "numeric"])
    ->map("GIX", ["formatCell" => "numeric"])
    ->map("MTO", ["formatCell" => "numeric"])
    ->map("MTOX", ["formatCell" => "numeric"])
    ->map("MTOR", ["formatCell" => "numeric"])
    ->map("MTI", ["formatCell" => "numeric"])
    ->map("ADJ", ["formatCell" => "numeric"])
    ->map(["E","END"], ["formatCell" => "numeric"])

    ->renderData()
    ->autoSize()
    ->end()
    ->getFileLink();
