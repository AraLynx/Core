<?php
?>
<div id='reportDiv_<?php echo $reportId;?>' class='reportDiv d-none'>
    <?php
    $gridParams = array(
        "page" => "report",
        "group" => "report",
        "id" => "_{$reportId}",
        // "isAutoFitColumn" => true,
        "toolbarString" => "<div class=\'btn btn-secondary align-middle\' onclick=\'reportGenerateExcelPrepareData({$reportId})\'>Export to Excel</div>",
        "columns" => array(
            array("title" => "No", "formatType" => "rowNumber"),
            array("field" => "Branch", "title" => "POS", "width" => 200),
            array("field" => "CaroserieNumberText", "title" => "Caroserie Number", "width" => 200),
            array("field" => "CaroserieVendor", "title" => "Caroserie Vendor", "width" => 250),
            array("field" => "CaroserieModel", "title" => "Model", "width" => 300),
            array("field" => "CaroserieType", "title" => "Type", "width" => 250),
            array("field" => "PONumber", "title" => "PO Caroserie / PO UAC", "width" => 175),
            array("field" => "VIN", "title" => "VIN", "width" => 150),
            array("field" => "EngineNumber", "title" => "Engine Number", "width" => 150),
            array("field" => "RefNumber", "title" => "SPK / UKAC Number", "width" => 175),
            array("field" => "SaldoAwal", "title" => "Saldo Awal", "formatType" => "currency"),
            array("field" => "Pembelian", "title" => "Pembelian", "formatType" => "currency"),
            array("field" => "Penjualan", "title" => "Penjualan", "formatType" => "currency"),
            array("field" => "SaldoAkhir", "title" => "Saldo Akhir", "formatType" => "currency"),
        ),
    );
    $grid = new \app\pages\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
    ?>
</div>