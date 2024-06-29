<?php
$headerInfos["Periode Nota"] = "{$ajax->getPost("DateStart")} s/d {$ajax->getPost("DateEnd")}";
$tryHeaderInfos["DivisionName"] = "Division";
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

$datas["FileLink"] = $spreadSheet
->startHeaderGroup("Tri Mandiri")
    ->map(["BrandName","Merk"])
    ->map(["CompanyName","Perusahaan"])
    ->map(["BranchName","Cabang"])
    ->map(["POSName","POS"])
->startHeaderGroup("Referensi")
    ->map(["ReferenceNumber","Dokumen"])
    ->map(["PartnerName","Konsumen"])
->startHeaderGroup("Penerimaan")
    ->map(["HariPenerimaan","Hari"])
    ->map(["ReceivedDate","Tanggal"])
    ->map(["ReceivedNumber","Dokumen"])
    ->map(["ReceiveNominal","Tunai"],["formatCell" => "currency", "aggregate" => "sum"])
    ->map(["ReceivedFromName","Penyetor"])
    ->map(["ReceivedByEmployeeName","Kasir"])
->startHeaderGroup("Setoran")
    ->map(["DepositDate","Tanggal"])
    ->map(["DepositReferenceNumber","Referensi"])
    ->map(["COA6Name","Akun Bank"])
    ->map(["Aging","Umur"],["formatCell" => "numeric"])
->renderData()
->autoSize()
->end()
->getFileLink();
