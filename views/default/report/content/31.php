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
            array("field" => "InvoiceNumber", "title" => "No Invoice", "width" => 100),
            array("field" => "InvoiceDate", "title" => "Invoice Date", "formatType" => "date"),
            array("field" => "Cabang", "width"=> 200),
            array("field" => "VehicleGroup", "title" => "Type","width" => 150),
            array("field" => "VehicleTypeAll", "title" => "Suffix"),
            array("field" => "RRN", "width" => 70),
            array("field" => "VIN", "title" => "No Rangka","width"=>150),
            array("field" => "EngineNumber", "title" => "No Mesin" ,"width" => 100),
            array("field" => "ColorDescription", "title" => "Warna", "width"=> 180),
            array("field" => "Quantity", "title" => "QTY", "formatType" => "numeric")
        ),
    );
    $grid = new \app\components\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
    ?>
</div>
