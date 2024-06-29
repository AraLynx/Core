<?php
$headerInfos["Periode"] = $ajax->getPost("DateStart")." s/d ".$ajax->getPost("DateEnd");

$headerParams = [
    "columnIndex" => 0,
    "rowIndex" => 1,
    "titleText" => $reportDescription,
    "mergeCellCount" => 5,
    "infos" => $headerInfos,
];
$spreadSheet->generateHeader($headerParams);

$datas["FileLink"] = $spreadSheet
    ->map(["Code","COA"])
    ->map(["Name","Akun"])
    ->map(["Balance","Saldo"], ["formatCell" => "currency"])

    ->setMapItems()
        ->map(["No","No"])
        ->map(["DateTime","Tanggal"])
        ->map(["ReferenceNumber","No Referensi"])
        ->map(["Description","Keterangan"])
        ->map(["Debit","Debit"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["Credit","Credit"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["Balance","Saldo"], ["formatCell" => "currency"])

    ->renderData()
    ->autoSize()
    ->end()
    ->getFileLink();
