<?php
$headerInfos["Periode GR"] = $ajax->getPost("GRDateStart") ." s/d ". $ajax->getPost("GRDateEnd");

$headerParams = [
    "columnIndex" => 0,
    "rowIndex" => 1,
    "titleText" => $reportDescription,
    "mergeCellCount" => 5,
    "infos" => $headerInfos,
];
$spreadSheet->generateHeader($headerParams);

// $datas["post"] = $ajax->getPost();

$datas["FileLink"] = $spreadSheet->map(["Branch","POS"])
    ->map(["CaroserieNumberText","Caroserie Number"])
    ->map(["CaroserieVendor","Caroserie Vendor"])
    ->map(["CaroserieModel","Model"])
    ->map(["CaroserieType","Type"])
    ->map(["PONumber","PO Caroserie / PO UAC"])
    ->map(["VIN","VIN"])
    ->map(["EngineNumber","Engine Number"])
    ->map(["RefNumber","SPK / UKAC Number"])
    ->map(["SaldoAwal","Saldo Awal"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->map(["Pembelian","Pembelian"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->map(["Penjualan","Penjualan"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->map(["SaldoAkhir","Saldo Akhir"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->renderData()
    ->autoSize()
    ->end()
    ->getFileLink();
