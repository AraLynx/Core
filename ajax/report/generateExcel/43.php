<?php
$headerParams = [
    "columnIndex" => 0,
    "rowIndex" => 1,
    "titleText" => $reportDescription,
    "mergeCellCount" => 5,
    "infos" => $headerInfos,
];
$spreadSheet->generateHeader($headerParams);

$datas["FileLink"] = $spreadSheet
    ->map(["CBPName","Cabang"])
    ->map(["SPKDistributionNumberText","No. Distribusi"])
    ->map(["DistributionDate","Tgl Distribusi"])
    ->map(["LeadDate","Telat (hari)"])
    ->map(["SPKNumberText","No. SPK"])
    ->map(["TeamLeaderEmployeeId","NIK TL"])
    ->map(["TeamLeaderEmployeeName","Nama TL"])
    ->map(["SalesmanEmployeeId","NIK Sales"])
    ->map(["SalesmanEmployeeName","Nama Sales"])
    ->renderData()
    ->autoSize()
    ->end()
    ->getFileLink();
