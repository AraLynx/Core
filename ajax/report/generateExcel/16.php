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

$datas["FileLink"] = $spreadSheet->map(["CBPName","POS / Outlet"])
    ->map(["NumberText","No. DS"])
    ->map(["DSDate","Tanggal DS"], ["formatCell" => "date"])
->startHeaderGroup("Sparepart")
    ->map(["SparepartCode","Kode"])
    ->map(["SparepartName","Nama"])
->endHeaderGroup()
    // ->map(["PRQuantity","PRQuantity"], ["formatCell" => "numeric"])
    ->map([["PRQuantity","PRUnit"],"GI Qty"],["glue" => " "])
    ->map(["COGS","COGS"], ["formatCell" => "currency", "aggregate" => "sum"])

    ->renderData()
    ->autoSize()
    ->end()
    ->getFileLink();
