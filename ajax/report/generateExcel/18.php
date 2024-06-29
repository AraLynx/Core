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
    ->map(["PSDate","Tanggal PS"])
    ->map(["PSNumberText","No. PS"])
    ->map(["PSPONumber","No. PO"])
    ->map(["PSPartSales","Part Sales"])
    ->map(["GIWarehouseName","Gudang"])
    ->map(["GIWarehouseRackName","Rak"])
    ->map(["PSCustomerName","Customer"])
    ->map(["Number","No"],["formatCell" => "numeric"])
    ->map(["SpGroup1Name","Grup"])
    ->map(["SpGroup2Name","Sub Grup"])
    ->map(["SpCode","Kode"])
    ->map(["SpName","Part"])
    ->map(["Quantity","Jumlah"],["formatCell" => "numeric"])
    ->map(["SpUnit","Satuan"])
    ->map(["PSSpSellingPrice","Harga @"],["formatCell" => "currency"])
    ->map(["PSSpSubTotal","Sub Total"],["formatCell" => "currency","aggregate" => "sum"])
    ->map(["PSSpSellingDiscount","Disc %"],["formatCell" => "percentage"])
    ->map(["PSSpSellingDiscountNominal","Disc Rp"],["formatCell" => "currency","aggregate" => "sum"])
    ->map("DPP",["formatCell" => "currency","aggregate" => "sum"])

    ->renderData()
    ->autoSize()
    ->end()
    ->getFileLink();
