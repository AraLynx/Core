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
            array("field" => "GRDate", "title" => "Tanggal Masuk", "formatType" => "date", "width" => 120),
            array("field" => "InvoiceDate", "title" => "Tanggal DO", "formatType" => "date"),
            array("field" => "BranchName", "title" => "Cabang"),
            array("title" => "Tipe Kendaraan", "template" => "#= VehicleGroup # #= VehicleType #", "width" => 270),
            array("field" => "ColorDescription", "title" => "Warna"),
            array("field" => "EngineNumber", "title" => "Nomor Mesin" , "width" => 120),
            array("field" => "Status","width" => 70),
        ),
    );
    $grid = new \app\components\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
    ?>
</div>
