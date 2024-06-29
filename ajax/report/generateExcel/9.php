<?php
$headerInfos["Periode"] = $ajax->getPost("PeriodeStart")." s/d ".$ajax->getPost("PeriodeEnd");

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
    ->map(["CDDate","Tgl Setor"], ["formatCell" => "date"])
    ->map(["CDBranchName","Cabang"])
    ->map(["CDCustomerName","Nama Konsumen"])
    ->map(["CDCustomerVehicleVIN","No Rangka"])
    ->map(["CDCustomerVehicleEngineNumber","No Mesin"])
    ->map(["CDNominal","Nominal"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->map(["CDCetakanNumber","No TTS"])

    ->map(["PKBNumberText1","No PKB 1"])
    ->map(["UsageNominal1","Nominal"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->map(["PKBNumberText2","No PKB 2"])
    ->map(["UsageNominal2","Nominal"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->map(["PKBNumberText3","No PKB 3"])
    ->map(["UsageNominal3","Nominal"], ["formatCell" => "currency", "aggregate" => "sum"])

    ->map(["CDBalance","SisaSaldo"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->map(["CDSellerName","Nama Penjual"])
    ->map(["CDDepositor","Nama Penyetor"])
    ->map(["CDMethod","Jenis Setoran"])

    ->renderData()
    ->autoSize()
    ->end()
    ->getFileLink();
