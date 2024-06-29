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

$datas["FileLink"] = $spreadSheet
    ->map(["CBPName","POS / Outlet"])
    ->map(["NumberText","No DS"])
    ->map(["DSDate","Tanggal DS"])
    ->map(["Customer","Konsumen"])
    ->map(["Sparepart","Sparepart"],["formatCell" => "currency","aggregate" => "sum"])

    ->renderData()
    ->autoSize()
    ->end()
    ->getFileLink();
