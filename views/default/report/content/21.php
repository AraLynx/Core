<?php
?>
<div id='reportDiv_<?php echo $reportId;?>' class='reportDiv d-none'>
    <?php
    $gridDetailInit = [
        "page" => "report",
        "group" => "report",
        "id" => "_{$reportId}Detail",
        "columns" => [
            //["title" => "No", "formatType" => "rowNumber"],
            ["field" => "RowNumber", "title" => "NO", "width" => 30, "formatType" => "numeric"],
            ["field" => "OF", "title" => " ", "width" => 30],
            ["field" => "KODE_OBJEK", "width" => 100],
            ["field" => "NAMA", "width" => 200],
            ["field" => "HARGA_SATUAN", "formatType" => "currency", "width" => 120],
            ["field" => "JUMLAH_BARANG", "formatType" => "numeric", "width" => 50],
            ["field" => "HARGA_TOTAL", "formatType" => "currency", "width" => 120],
            ["field" => "DISKON", "formatType" => "currency", "width" => 120],
            ["field" => "DPP", "formatType" => "currency", "width" => 120],
            ["field" => "PPN", "formatType" => "currency", "width" => 120],
            ["field" => "TARIF_PPNBM", "formatType" => "currency", "width" => 120],
            ["field" => "PPNBM", "formatType" => "currency", "width" => 120],
        ],
        "isDetailInit" => true
    ];
    $gridDetailInit = new \app\components\KendoGrid($gridDetailInit);
    $gridDetailInit->begin();
    $gridDetailInitFunctionName = $gridDetailInit->end();
    $gridDetailInit->render();

    $gridParams = array(
        "page" => "report",
        "group" => "report",
        "id" => "_{$reportId}",
        "toolbarString" => "<div class=\'btn btn-secondary align-middle\' onclick=\'reportGenerateExcelPrepareData({$reportId})\'>Export to Excel</div>",
        "columns" => [
            ["title" => "No", "formatType" => "rowNumber"],
            ["field" => "FK", "title" => " ", "width" => 30],
            ["field" => "KD_JENIS_TRANSAKSI", "width" => 30],
            ["field" => "FG_PENGGANTI", "formatType" => "numeric", "width" => 30],
            ["field" => "NOMOR_FAKTUR", "width" => 130],
            ["field" => "MASA_PAJAK", "formatType" => "numeric", "width" => 30],
            ["field" => "TAHUN_PAJAK", "formatType" => "numeric", "width" => 50],
            ["field" => "TANGGAL_FAKTUR", "formatType" => "numeric", "width" => 100],
            ["field" => "NPWP", "width" => 120],
            ["field" => "NAMA", "width" => 200],
            ["field" => "ALAMAT_LENGKAP", "width" => 300],
            ["field" => "JUMLAH_DPP", "formatType" => "currency", "width" => 120],
            ["field" => "JUMLAH_PPN", "formatType" => "currency", "width" => 120],
            ["field" => "JUMLAH_PPNBM", "formatType" => "currency", "width" => 50],
            ["field" => "ID_KETERANGAN_TAMBAHAN", "width" => 50],
            ["field" => "FG_UANG_MUKA", "formatType" => "currency", "width" => 50],
            ["field" => "UANG_MUKA_DPP", "formatType" => "currency", "width" => 50],
            ["field" => "UANG_MUKA_PPN", "formatType" => "currency", "width" => 50],
            ["field" => "UANG_MUKA_PPNBM", "formatType" => "currency", "width" => 50],
            ["field" => "REFERENSI", "width" => 200],
            ["field" => "KODE_DOKUMEN_PENDUKUNG", "width" => 50]
        ],
        "detailInit" => $gridDetailInitFunctionName
    );
    $grid = new \app\components\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
    ?>
</div>
