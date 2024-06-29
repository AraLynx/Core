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

$datas["FileLink"] = $spreadSheet->map([["BranchAlias","POSName"],"POS / Outlet"],["glue" => ", "])
        ->map(["PKBDate","Tgl PKB"], ["formatCell" => "date"])
        ->map(["PKBNumberText","No PKB"])
        ->map(["PKBType","Tipe (WalkIn/DMS/BIB)"])
        ->map(["Mechanics","Mekanik"])

        ->map(["VehiclePoliceNumber","No Polisi"], ["replace" => ["_",""]])
        ->map([["VehicleBrand","VehicleType"],"Tipe Kendaraan"], ["glue" => ", "])
        ->map(["VehicleVIN","No Rangka"])
        ->map(["VehicleEngineNumber","No Mesin"])
        ->map(["VehicleYear","Tahun"])
        ->map(["Kilometer","KM"])

        ->map([["CustomerTitle","CustomerName"],"Pemilik"], ["glue" => " "])
        ->map(["CustomerNPWPNumber","NPWP"])
        ->map(["CustomerKTPNumber","KTP"])
        ->map([["CustomerMobilePhone1","CustomerMobilePhone2"],"Telp"], ["glue" => ", "])
        ->map([["CustomerAddressLine1","CustomerAddressLine2"],"Alamat"], ["glue" => ", "])
        ->map(["CustomerAddressKabupaten","Kota"])

        ->map(["ItemNumber","No"])
        ->map(["ChargeTo","Charge To"])
        ->map(["Product","Grup"])
        ->map(["Type","Tipe"])
        ->map(["ProductCode","Kode"])
        ->map(["ProductName","Produk"])
        ->map(["Qty","Qty"], ["formatCell" => "numeric"])
        ->map(["Unit","Unit"])
        ->map(["Storage","Rak"])

        ->map(["Each","Satuan"], ["formatCell" => "currency"])
        ->map(["Retail","Retail"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["DiscountPercentage","Diskon %"], ["formatCell" => "percentage"])
        ->map(["DiscountNominal","Diskon Rp"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["DPP","DPP"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->renderData()
        ->autoSize()
        ->end()
        ->getFileLink();