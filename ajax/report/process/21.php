<?php

$q = "EXEC [SP_Sys_Report_ReportGetReport_{$ReportId}]";
$q .= $SP->SPGenerateParameters();
//$data = $q;
$SP->SPPrepare($q);

$SP->addSanitation("INVOICE_OUT_ID",["int"]);
$SP->addSanitation("FK",["string"]);
$SP->addSanitation("KD_JENIS_TRANSAKSI",["string"]);
$SP->addSanitation("FG_PENGGANTI",["int"]);
$SP->addSanitation("NOMOR_FAKTUR",["string"]);
$SP->addSanitation("MASA_PAJAK",["int"]);
$SP->addSanitation("TAHUN_PAJAK",["int"]);
$SP->addSanitation("TANGGAL_FAKTUR",["string"]);
$SP->addSanitation("NPWP",["string"]);
$SP->addSanitation("NAMA",["string"]);
$SP->addSanitation("ALAMAT_LENGKAP",["string"]);
$SP->addSanitation("JUMLAH_DPP",["int"]);
$SP->addSanitation("JUMLAH_PPN",["int"]);
$SP->addSanitation("JUMLAH_PPNBM",["int"]);
$SP->addSanitation("ID_KETERANGAN_TAMBAHAN",["int"]);
$SP->addSanitation("FG_UANG_MUKA",["int"]);
$SP->addSanitation("UANG_MUKA_DPP",["int"]);
$SP->addSanitation("UANG_MUKA_PPN",["int"]);
$SP->addSanitation("UANG_MUKA_PPNBM",["int"]);
$SP->addSanitation("REFERENSI",["string"]);
$SP->addSanitation("KODE_DOKUMEN_PENDUKUNG",["string"]);
$SP->addSanitation("TotalDifferenceTax",["int"]);

$SP->execute();
$rows = $SP->getRow();
foreach($rows AS $row)
{
    $row["Items"] = [];
    $InvoiceOuts[$row["INVOICE_OUT_ID"]] = $row;
}

//== Sanitize ouput
$SP->addSanitation("INVOICE_OUT_ITEM_ID",["int"]);
$SP->addSanitation("INVOICE_OUT_ID",["int"]);
$SP->addSanitation("OF",["string"]);
$SP->addSanitation("ItemName",["string"]);
$SP->addSanitation("HARGA_SATUAN",["int"]);
$SP->addSanitation("JUMLAH_BARANG",["dec"]);
$SP->addSanitation("HARGA_TOTAL",["int"]);
$SP->addSanitation("DISKON",["int"]);
$SP->addSanitation("DPP",["int"]);
$SP->addSanitation("PPN",["int"]);
$SP->addSanitation("TARIF_PPNBM",["int"]);
$SP->addSanitation("PPNBM",["int"]);
$SP->nextRowset();
$rows = $SP->getRow();
foreach($rows AS $row)
{
    $InvoiceOutId = $row["INVOICE_OUT_ID"];
    $ItemName = $row["ItemName"];

    $ItemArray = explode("]", $ItemName);
    $row["KODE_OBJEK"] = str_replace(["[","]"],"",$ItemArray[0]);

    $row["NAMA"] = str_replace(["[{$row["KODE_OBJEK"]}] "],"",$ItemName);
    unset($row["ItemName"]);

    if(!count($InvoiceOuts[$InvoiceOutId]["Items"]))
    {
        $rowNumber = 1;
    }
    else
    {
        $rowNumber++;
    }
    $row["RowNumber"] = $rowNumber;


    if($InvoiceOuts[$InvoiceOutId]["TotalDifferenceTax"])
    {
        $row["PPN"]++;
        $InvoiceOuts[$InvoiceOutId]["TotalDifferenceTax"]--;
    }

    $InvoiceOuts[$InvoiceOutId]["Items"][] = $row;
}

foreach($InvoiceOuts AS $InvoiceOut)
{
    $report[] = $InvoiceOut;
}
