<?php
if($ajax->getPost("Field") == "InvoiceNumber")$desc = "No DO";
if($ajax->getPost("Field") == "EngineNumber")$desc = "No Mesin";
if($ajax->getPost("Field") == "VIN")$desc = "No Rangka";
$headerInfos[$desc] = $ajax->getPost("Value");

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

$datas["FileLink"] = $spreadSheet->map(["DateTime","Tanggal & Waktu"],["formatCell" => "dateTime"])
        ->map(["TransactionName","Kegiatan"])
        ->map(["ReferenceNumber","No Referensi"])
        ->map([["LocationPartnerType", "LocationPartner"],"Lokasi"])
        ->map("Status")
        ->renderData()
        ->autoSize()
        ->end()
        ->getFileLink();
