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
            array("title" => "No", "formatType" => "rowNumber"),
            array("field" => "UnitOwned", "title" => "Kepemilikan","width" => 150),
            array("field" => "InvoiceDate", "title" => "Tanggal DO", "formatType" => "date"),
            array("title" => "Tipe Kendaraan", "template" => "#= VehicleGroup # #= VehicleType #","width" => 150),
            array("field" => "ColorDescription", "title" => "Warna","width" => 100),
            array("field" => "EngineNumber", "title" => "No Mesin","width" => 120),
            array("field" => "UnitLocation", "title" => "Lokasi","width" => 200),
            array("field" => "GRDate", "title" => "Tanggal Masuk", "formatType" => "date","width" => 120),
            array("field" => "Status"),
        ),
    );
    $grid = new \app\pages\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
    ?>
</div>
