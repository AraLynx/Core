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
    ->map("Company")
    ->map("Branch")
    ->map("POS")
    ->map("Brand")

    ->map(["TanggalTransaksi","Tanggal Transaksi"], ["formatCell" => "date"])
    ->map(["NoTransaksi","No Transaksi"])
    ->map(["Type","Group"])
    ->map(["Group","Sub Group"])
    ->map("Code")
    ->map("Sparepart")

    ->map("Capital", ["formatCell" => "currency", "aggregate" => "sum"])
    ->map("Sell", ["formatCell" => "currency", "aggregate" => "sum"])
    ->map("Quantity", ["formatCell" => "numeric"])
    ->map("Unit")
    ->map("Category")
    ->map("Warehouse")
    ->map("Rack")
    ->map("Remark")

    ->renderData()
    ->autoSize()
    ->end()
    ->getFileLink();
