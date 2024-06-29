<?php
$headerInfos["Periode"] = "{$dateStart} s/d {$dateEnd} ({$field})";

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

$datas["FileLink"] = $spreadSheet->map(["CompanyAlias", "PT"])
    ->map(["BranchAlias", "CABANG"])
    ->map(["POSName", "POS"])
    ->map(["SPKCompleteDate","TGL NOTA"], ["formatCell" => "date"])
    ->map(["SPKNumberText","NO SPK"])
    ->map(["CustomerName","NAMA KONSUMEN"])
    ->map(["VehicleGroupName","GROUP"])
    ->map(["VehicleTypeName","TYPE"])
    ->map(["UnitVIN","NO RANGKA"])
    ->map(["UnitEngineNumber","NO MESIN"])
    ->map(["ClaimProgramTypeName","CLAIM PROGRAM"])
    ->map(["ClaimDate","TGL CLAIM"], ["formatCell" => "date"])
    ->map(["ClaimNumberText","NO CLAIM"])
    ->map(["ClaimNominal","NOMINAL"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->map(["LoanPaymentSaldo","SALDO"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->map(["LoanPaymentDate","TGL PELUNASAN"], ["formatCell" => "date"])
    ->map(["LoanPaymentReferenceNumber","NO REF PELUNASAN"])
    ->renderData()
    ->autoSize()
    ->end()
    ->getFileLink();
