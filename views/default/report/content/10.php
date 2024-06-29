<?php
?>
<div id='reportDiv_<?php echo $reportId;?>' class='reportDiv d-none'>
    <?php
    $gridParams = array(
        "page" => "report",
        "group" => "report",
        "id" => "_{$reportId}",
        "toolbarString" => "<div class=\'btn btn-secondary align-middle\' onclick=\'reportGenerateExcelPrepareData({$reportId})\'>Export to Excel</div>",
        "columns" => array(
            ["formatType" => "rowNumber"],
            ["field" => "VehicleGroupType", "title" => "Tipe", "width" => 400],
            ["field" => "UnitColorDescription", "title" => "Warna", "width" => 200],
            ["field" => "UnitVIN", "title" => "No Rangka", "width" => 150],
            ["field" => "UnitEngineNumber", "title" => "No Mesin", "width" => 100],
            ["field" => "UnitYear", "title" => "Tahun", "width" => 100],
            ["field" => "Status", "title" => "Status", "width" => 150],
            ["field" => "Location", "title" => "Lokasi", "width" => 350],
            ["field" => "InvoiceDate", "title" => "Tanggal DO", "width" => 120],
            ["field" => "Age", "title" => "Umur (Hari)", "width" => 100],
            ["field" => "Free", "title" => "Free", "width" => 100],
            ["field" => "Booked", "title" => "Booked", "formatType" => "numberText"],
            ["field" => "Sold", "title" => "Terjual", "formatType" => "invoiceNumberText"],
            ["field" => "Return", "title" => "Retur", "width" => 100],
        ),
    );
    $grid = new \app\pages\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
    ?>
</div>
