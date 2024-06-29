<?php
$tryHeaderInfos["VehicleGroupName"] = "Vehicle Group";
$tryHeaderInfos["VehicleTypeName"] = "Vehicle Type";
$tryHeaderInfos["ColorDescription"] = "Warna";
$tryHeaderInfos["EngineNumber"] = "No Mesin";
$tryHeaderInfos["VIN"] = "No Rangka";
$tryHeaderInfos["Year"] = "Thn Rangka";
$tryHeaderInfos["StatusName"] = "Status";

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

$datas["FileLink"] = $spreadSheet->map(["UnitKepemilikan","Unit Kepemilikan"])
        ->map(["TipeKendaraan","Tipe Kendaraan"])
        ->map(["Warna","Warna"])
        ->map(["NoRangka","No Rangka"])
        ->map(["NoMesin","No Mesin"])
        ->map(["Status","Status"])
        ->map(["Lokasi","Lokasi"])
        ->map(["Umur","Umur"],["formatCell" => "numeric"])
        ->map(["Free","Free"],["aggregate" => "counta"])
        ->map(["Booked","Booked"],["aggregate" => "counta"])
        ->map(["CalonPelanggan","Calon Pelanggan"])
        ->map(["Salesman","Salesman"])
        ->renderData()
        ->autoSize()
        ->end()
        ->getFileLink();
