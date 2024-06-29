<?php
$headerInfos["Periode"] = "{$Year}-{$Month}";

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

$datas["FileLink"] = $spreadSheet->map("Company")
    ->map("Branch")
    ->map("POS")
    ->map(["Date","Date"])
    ->map(["LoanType","Type"])
    ->map(["LoanCategory","Category"])
    ->map(["COAName","COA"])
    ->map(["LoanNominal","Loan"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->map(["PartnerType","Partner Type"])
    ->map(["Partner","Partner Name"])
    ->map(["ReferenceNumber","Reference"])
    ->map("Description")
    ->map(["LoanPaymentNominal","Payment"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->map(["LoanBalance","Balance"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->renderData()
    ->autoSize()
    ->end()
    ->getFileLink();
