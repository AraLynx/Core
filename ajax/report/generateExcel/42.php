<?php
$DateType = $ajax->getPost("DateType");
if($DateType == "SPKCompleteDate")$headerInfos["Periode Nota"] = $ajax->getPost("DateStart")." s/d ".$ajax->getPost("DateEnd");
if($DateType == "LoanPaymentDate")$headerInfos["Periode Pelunasan"] = $ajax->getPost("DateStart")." s/d ".$ajax->getPost("DateEnd");

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
    ->map(["CBPName","Cabang"])
    ->map(["NumberText","No. SPK"])
    ->map(["NotaDate","Tgl Nota"])
    ->map(["CustomerName","Nama Pemesan"])
    ->map(["STNKCustomerName","Nama STNK"])
    ->map(["UnitVIN","No Rangka"])
    ->map(["UnitEngineNumber","No Mesin"])
    ->map(["UnitColor","Warna"])
    ->map(["VehicleGroup","Model"])
    ->map(["VehicleType","Tipe"])
    ->map(["LeasingVendorName","Nama Leasing"])
    ->map(["PaymentDate","Tgl. Pelunasan"])
    ->map(["LoanPaymentNominal","Nominal Pelunasan"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->renderData()
    ->autoSize()
    ->end()
    ->getFileLink();
