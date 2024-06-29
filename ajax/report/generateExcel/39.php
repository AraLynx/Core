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
    ->map([["BranchAlias","POSName"],"POS / Outlet"],["glue" => ", "])

    ->map(["InvoiceDate","Nota"], ["formatCell" => "date"])
    ->map(["PKBDate","UE"])
    ->map(["PKBNumberText","No Order"])

    ->map(["VehiclePoliceNumber","No Polisi"])
    ->map(["VehicleBrandType","Tipe Kendaraan"])
    ->map(["VehicleVIN","No Rangka"])
    ->map(["VehicleEngineNumber","No Mesin"])
    ->map(["VehicleYear","Tahun"], ["formatCell" => "numeric"])
    ->map(["Kilometer","KM"], ["formatCell" => "numeric"])
    ->map(["CustomerName","Pemilik"])

    ->map(["PKBSparepartCostCounter","No"], ["formatCell" => "numeric"])
    ->map(["ChargeTo","Charge To"])
    ->map(["SparepartCode","Kode"])
    ->map(["SparepartName","Produk"])
    ->map(["SparepartCostQuantity","Qty"], ["formatCell" => "numeric"])
    ->map(["SparepartUnitName","Unit"])

    ->map(["WarehouseName","Gudang"])
    ->map(["WarehouseRackName","Rak"])
    ->map(["PartRequisitionItemValueEach","Produk"], ["formatCell" => "currency"])
    ->map(["PartRequisitionItemValue","Produk"], ["formatCell" => "currency", "aggregate" => "sum"])

    ->renderData()
    ->autoSize()
    ->end()
    ->getFileLink();
