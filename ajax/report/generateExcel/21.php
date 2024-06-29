<?php
$headerInfos["Periode Nota"] = $ajax->getPost("InvoiceDateStart")." s/d ".$ajax->getPost("InvoiceDateEnd");
if($ajax->getPost("ReferenceTypeId") == "*")$headerInfos["Tipe"] = "PKB + DS + PS";
if($ajax->getPost("ReferenceTypeId") == 6)$headerInfos["Tipe"] = "PKB";
if($ajax->getPost("ReferenceTypeId") == 7)$headerInfos["Tipe"] = "DS";
if($ajax->getPost("ReferenceTypeId") == 30)$headerInfos["Tipe"] = "PS";

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

//GENERATE HEADER
$headerInv = $report[0];
$InvoiceHeaders = [
    "FK","KD_JENIS_TRANSAKSI","FG_PENGGANTI"
    ,"NOMOR_FAKTUR",["MASA_PAJAK","numeric"],["TAHUN_PAJAK","numeric"],"TANGGAL_FAKTUR"
    ,"NPWP","NAMA","ALAMAT_LENGKAP"
    ,["JUMLAH_DPP","numeric"],["JUMLAH_PPN","numeric"],["JUMLAH_PPNBM","numeric"],"ID_KETERANGAN_TAMBAHAN"
    ,"FG_UANG_MUKA",["UANG_MUKA_DPP","numeric"],["UANG_MUKA_PPN","numeric"],["UANG_MUKA_PPNBM","numeric"]
    ,"REFERENSI","KODE_DOKUMEN_PENDUKUNG"
];
$InvoiceCustomerHeaders = [
    "LT","NPWP","NAMA"
    ,"JALAN","BLOK","NOMOR","RT","RW","KECAMATAN","KELURAHAN","KABUPATEN","PROPINSI","KODE_POS","NOMOR_TELEPON"
];
$InvoiceItemHeaders = [
    "OF","KODE_OBJEK","NAMA"
    ,["HARGA_SATUAN","numeric"],["JUMLAH_BARANG","numeric"],["HARGA_TOTAL","numeric"]
    ,["DISKON","numeric"],["DPP","numeric"],["PPN","numeric"]
    ,["TARIF_PPNBM","numeric"],["PPNBM","numeric"],
];
foreach($InvoiceHeaders AS $index => $InvoiceHeader)
{
    $cell = $spreadSheet->getNumToAlpha($index).$spreadSheet->getNowRowIndex();
    $headerName = is_array($InvoiceHeader) ? $InvoiceHeader[0] : $InvoiceHeader;
    $spreadSheet->setCellValue($cell, $headerName);
}
$spreadSheet->setNextNowRowIndex();

foreach($InvoiceCustomerHeaders AS $index => $InvoiceHeader)
{
    $cell = $spreadSheet->getNumToAlpha($index).$spreadSheet->getNowRowIndex();
    $headerName = is_array($InvoiceHeader) ? $InvoiceHeader[0] : $InvoiceHeader;
    $spreadSheet->setCellValue($cell, $headerName);
}
$spreadSheet->setNextNowRowIndex();

foreach($InvoiceItemHeaders AS $index => $InvoiceHeader)
{
    $cell = $spreadSheet->getNumToAlpha($index).$spreadSheet->getNowRowIndex();
    $headerName = is_array($InvoiceHeader) ? $InvoiceHeader[0] : $InvoiceHeader;
    $spreadSheet->setCellValue($cell, $headerName);
}
$spreadSheet->setNextNowRowIndex();

foreach($report AS $inv)
{
    foreach($InvoiceHeaders AS $index => $InvoiceHeader)
    {
        $headerName = is_array($InvoiceHeader) ? $InvoiceHeader[0] : $InvoiceHeader;
        $formatCell = is_array($InvoiceHeader) ? $InvoiceHeader[1] : "string";

        $cell = $spreadSheet->getNumToAlpha($index).$spreadSheet->getNowRowIndex();
        $value = $inv[$headerName];

        if($formatCell == "string")
        {
            $spreadSheet->setCellValueExplicit($cell, $value, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        }
        if($formatCell == "currency")
        {
            $spreadSheet->getStyle($cell)->getNumberFormat()->setFormatCode('#,##0');
            $spreadSheet->setCellValueExplicit($cell, $value, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        }
        if($formatCell == "numeric")
        {
            $spreadSheet->setCellValueExplicit($cell, $value, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        }
        if($formatCell == "percentage")
        {
            $spreadSheet->getStyle($cell)->getNumberFormat()->setFormatCode('#,##0.00 %');
            $spreadSheet->setCellValueExplicit($cell, $value/100, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        }

        if($formatCell == "date")
        {
            $spreadSheet->setCellValueExplicit($cell, substr($value,0,10), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        }
        if($formatCell == "time")
        {
            $spreadSheet->setCellValueExplicit($cell, substr($value,0,8), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        }
        if($formatCell == "dateTime")
        {
            $spreadSheet->setCellValueExplicit($cell, substr($value,0,19), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        }
    }
    $spreadSheet->setNextNowRowIndex();

    foreach($inv["Items"] AS $invItem)
    {
        foreach($InvoiceItemHeaders AS $index => $InvoiceItemHeader)
        {
            $headerName = is_array($InvoiceItemHeader) ? $InvoiceItemHeader[0] : $InvoiceItemHeader;
            $formatCell = is_array($InvoiceItemHeader) ? $InvoiceItemHeader[1] : "string";

            $cell = $spreadSheet->getNumToAlpha($index).$spreadSheet->getNowRowIndex();
            $value = $invItem[$headerName];

            if($formatCell == "string")
            {
                $spreadSheet->setCellValueExplicit($cell, $value, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            }
            if($formatCell == "currency")
            {
                $spreadSheet->getStyle($cell)->getNumberFormat()->setFormatCode('#,##0');
                $spreadSheet->setCellValueExplicit($cell, $value, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
            }
            if($formatCell == "numeric")
            {
                $spreadSheet->setCellValueExplicit($cell, $value, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
            }
            if($formatCell == "percentage")
            {
                $spreadSheet->getStyle($cell)->getNumberFormat()->setFormatCode('#,##0.00 %');
                $spreadSheet->setCellValueExplicit($cell, $value/100, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
            }

            if($formatCell == "date")
            {
                $spreadSheet->setCellValueExplicit($cell, substr($value,0,10), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            }
            if($formatCell == "time")
            {
                $spreadSheet->setCellValueExplicit($cell, substr($value,0,8), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            }
            if($formatCell == "dateTime")
            {
                $spreadSheet->setCellValueExplicit($cell, substr($value,0,19), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            }
        }
        $spreadSheet->setNextNowRowIndex();
    }
}

$spreadSheet->setNowColumnIndex(count($InvoiceHeaders));

$datas["FileLink"] = $spreadSheet
->autoSize()
->end()
->getFileLink();
