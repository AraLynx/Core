<?php
$headerInfos["Klik Posting"] = $ajax->getPost("DateStart")." s/d ".$ajax->getPost("DateEnd");
$tryHeaderInfos["SPKNumber"] = "No SPK";
$tryHeaderInfos["DocumentNumber"] = "No Dokumen";
$tryHeaderInfos["ReferenceNumber"] = "No Referensi";

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
    ->startHeaderGroup("SPK")
        ->map(["SPKDate","Tanggal SPK"], ["formatCell" => "date"])
        ->map(["SPKNumber","No SPK"])
        ->map(["SPKInvoiceDate","Tanggal Nota"])
        ->map(["SPKDiscountPrice","Diskon"], ["formatCell" => "currency"])
        ->map(["SPKCustomerName","Konsumen"])
        ->map(["SPKSTNKName", "Nama STNK"])
        ->map(["SPKMobilePhone", "No HP"])
        ->map(["SPKUnitType", "Tipe Unit"])
        ->map(["SPKVIN", "No Rangka"])
        ->map(["SPKSellingType", "Tipe Penjualan"])
        ->map(["SPKLeasingVendorName", "Vendor Leasing"])
    ->endHeaderGroup()

    ->startHeaderGroup("Titipan")
        ->map(["DepositCompleteDate", "Klik Posting"], ["formatCell" => "date"])
        ->map(["DepositDate", "Tgl Terima"], ["formatCell" => "date"])
        ->map(["DepositDocumentNumber", "No Dokumen"])
        ->map(["DepositPaymentMenthod", "Metode Bayar"])
        ->map(["DepositNominal", "Nominal"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["SPKSalesName", "Nama Sales"])
        ->map(["SPKLeaderName", "Nama Leader"])
    ->endHeaderGroup()

    ->startHeaderGroup("Setoran")
        ->map(["SetoranDate", "Tgl Setoran"], ["formatCell" => "date"])
        ->map(["SetoranReferenceNumber", "No Referensi"])
        ->map(["SetoranAccount", "Akun"])
        ->map(["SetoranAge", "Umur"])
        ->map(["SetoranStatus", "Status"])
    ->endHeaderGroup()

    ->map(["TotalCustomerDeposit", "Total Uang Masuk"], ["formatCell" => "currency", "aggregate" => "sum"])

    ->renderData()
    ->autoSize()
    ->end()
    ->getFileLink();
