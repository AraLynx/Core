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
            array("field" => "POS", "title" => "POS", "width" => 225),
            array("field" => "CaroserieNumberText", "title" => "Caroserie Number", "width" => 200),
            array("field" => "VendorName", "title" => "Caroserie Vendor", "width" => 300),
            array("field" => "ModelName", "title" => "Model", "width" => 250),
            array("field" => "TypeName", "title" => "Type", "width" => 200),
            array("field" => "ReferenceNumberText", "title" => "PO Caroserie / PO UAC", "width" => 200),
            array("field" => "PODate", "title" => "PO Date", "formatType" => "date", "width" => 150),
            array("field" => "GRDate", "title" => "GR Date", "formatType" => "date", "width" => 150),
            array("field" => "InvoiceNumber", "title" => "Invoice Number", "width" => 225),
            array("field" => "InvoiceDate", "title" => "Invoice Date", "formatType" => "date", "width" => 150),
            array("field" => "PaymentDate", "title" => "Payment Date", "formatType" => "date", "width" => 150),
            array("field" => "EngineNumber", "title" => "Engine Number", "width" => 150),
            array("field" => "VIN", "title" => "VIN", "width" => 150),
            array("field" => "DPPNominal", "title" => "DPP", "formatType" => "currency"),
            array("field" => "PPnNominal", "title" => "PPN", "formatType" => "currency"),
            array("field" => "SubTotalNominal", "title" => "Hutang", "formatType" => "currency"),
        ),
    );
    $grid = new \app\pages\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
    ?>
</div>