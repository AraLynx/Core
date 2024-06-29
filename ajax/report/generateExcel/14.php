<?php
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

$datas["FileLink"] = $spreadSheet->map(["CBPName"," / Outlet"])
    ->map(["NumberText","No. PKB"])
    ->map(["UEDate","Tanggal UE"], ["formatCell" => "date"])
->startHeaderGroup("Sparepart")
    ->map(["SparepartCode","Kode"])
    ->map(["SparepartName","Nama"])
->endHeaderGroup()
    ->map([["PRQuantity","PRUnit"],"GI Qty"],["glue" => " "])
    ->map(["COGS","COGS"], ["formatCell" => "currency", "aggregate" => "sum"])

    ->renderData()
    ->autoSize()
    ->end()
    ->getFileLink();
