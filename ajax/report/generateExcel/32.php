<?php
$headerInfos["Periode"] = "{$ajax->getPost("DateYear")}-{$ajax->getPost("DateMonth")}";

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
//$datas["post"] = $ajax->getPost();

$datas["FileLink"] = $spreadSheet
    ->map(["CBPName","POS / Outlet"])
    ->map(["SAEmployeeName","Nama Service Advisor"])
    ->map(["PKBCount","Jumlah PKB"], ["formatCell" => "numeric", "aggregate" => "sum"])
    ->map(["Service","Jasa"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->map(["Genuine","Part Genuine"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->map(["NonGenuine","Non Genuine"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->map(["Total","Total"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->renderData()
    ->autoSize()
    ->end()
    ->getFileLink();
