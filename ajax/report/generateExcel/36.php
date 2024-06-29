<?php
$headerInfos["Periode GR"] = $ajax->getPost("GRDateStart") ." s/d ". $ajax->getPost("GRDateEnd");

$tryHeaderInfos["CaroserieNumber"] = "Caroserie Number";
$tryHeaderInfos["PONumber"] = "PO Number";
if($ajax->getPost("UnitIdentityType") == "EngineNumber")$tryHeaderInfos["EngineNumber"] = "Engine Number";
if($ajax->getPost("UnitIdentityType") == "VIN")$tryHeaderInfos["VIN"] = "VIN";

foreach($tryHeaderInfos AS $inputName => $description)
{
    if ($ajax->getPost("UnitIdentityValue"))
    {
        if(in_array($inputName, ["VIN","EngineNumber"])) $headerInfos[$description] = $ajax->getPost("UnitIdentityValue");
    } 

    if ($ajax->getPost($inputName))
    {
        $headerInfos[$description] = $ajax->getPost($inputName);
    }
}

$headerParams = [
    "columnIndex" => 0,
    "rowIndex" => 1,
    "titleText" => $reportDescription,
    "mergeCellCount" => 5,
    "infos" => $headerInfos,
];
$spreadSheet->generateHeader($headerParams);

// $datas["post"] = $ajax->getPost();

$datas["FileLink"] = $spreadSheet->map(["POS","POS"])
    ->map(["CaroserieNumberText","Caroserie Number"])
    ->map(["VendorName","Caroserie Vendor"])
    ->map(["ModelName","Model"])
    ->map(["TypeName","Type"])
    ->map(["ReferenceNumberText","PO Caroserie / PO UAC"])
    ->map(["PODate","PO Date"])
    ->map(["GRDate","GR Date"])
    ->map(["InvoiceNumber","Invoice Number"])
    ->map(["InvoiceDate","Invoice Date"])
    ->map(["PaymentDate","Payment Date"])
    ->map(["EngineNumber","Engine Number"])
    ->map(["VIN","VIN"])
    ->map(["DPPNominal","DPP Nominal"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->map(["PPnNominal","PPn Nominal"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->map(["SubTotalNominal","Hutang"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->renderData()
    ->autoSize()
    ->end()
    ->getFileLink();
