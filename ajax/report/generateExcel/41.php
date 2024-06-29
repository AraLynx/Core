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
    //->map([["BranchAlias","POSName"],"POS / Outlet"],["glue" => ", "])
    ->map(["LeasingARInsuranceRefund","Nilai Refund"], ["formatCell" => "currency", "aggregate" => "sum"])

    ->map(["BankDate","Tgl Bank"], ["formatCell" => "date"])
    ->map(["BankReferenceNumber","No Referensi Bank"])
    ->map(["BankNominal","Jumlah Bank"], ["formatCell" => "currency", "aggregate" => "sum"])

    ->map(["NumberText","No SPK"])
    ->map(["InvoiceDate","Tgl. Nota"], ["formatCell" => "date"])
    ->map(["Customer","Nama"])
    ->map(["UnitVIN","No Rangka"])
    ->map(["UnitEngineNumber","No Mesin"])

    ->map(["LeasingVendorName","Leasing"])

    ->renderData()
    ->autoSize()
    ->end()
    ->getFileLink();
