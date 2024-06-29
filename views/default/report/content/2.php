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
            array("field" => "Company", "title" => "Company", "width" => 100),
            array("field" => "Branch", "title" => "Branch", "width" => 100),
            array("field" => "POS", "title" => "POS", "width" => 150),
            array("field" => "Date", "title" => "Date", "formatType" => "date"),

            array("field" => "LoanType", "title" => "Type", "width" => 100),
            array("field" => "LoanCategory", "title" => "Category", "width" => 300),
            array("field" => "COAName", "title" => "COA", "width" => 150),
            array("field" => "LoanNominal", "title" => "Loan", "formatType" => "currency"),
            array("field" => "PartnerType", "title" => "Partner Type", "width" => 100),
            array("field" => "Partner", "title" => "Partner Name", "width" => 200),
            array("field" => "ReferenceNumber", "title" => "Reference", "width" => 250),
            array("field" => "Description", "title" => "Description", "width" => 300),
            array("field" => "LoanPaymentNominal", "title" => "Payment", "formatType" => "currency"),
            array("field" => "LoanBalance", "title" => "Balance",  "formatType" => "currency"),
        ),
    );
    $grid = new \app\pages\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
    ?>
</div>
