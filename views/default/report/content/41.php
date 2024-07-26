<?php
?>
<div id='reportDiv_<?php echo $reportId;?>' class='reportDiv d-none'>
    <?php
    $gridParams = [
        "page" => "report",
        "group" => "report",
        "id" => "_{$reportId}",
        "toolbarString" => "<div class=\'btn btn-secondary align-middle\' onclick=\'reportGenerateExcelPrepareData({$reportId})\'>Export to Excel</div>",
        "columns" => [
            ["title" => "No", "formatType" => "rowNumber"],
            //["title" => "POS / Outlet", "width" => 250, "template" => "#= BranchAlias #, #= POSName #"],
            ["field" => "LeasingARInsuranceRefund", "title" => "Nilai Refund", "formatType" => "currency"],

            ["title" => "Bank","columns" => [
                ["field" => "BankDate", "title" => "Tgl", "formatType" => "date"],
                ["field" => "BankReferenceNumber", "title" => "No Referensi", "width" => 150],
                ["field" => "BankNominal", "title" => "Jumlah", "formatType" => "currency"],
            ]],
            ["field" => "NumberText", "title" => "No SPK", "formatType" => "numberText"],
            ["field" => "InvoiceDate", "title" => "Tgl. Nota", "formatType" => "date"],
            ["field" => "Customer", "title" => "Nama", "formatType" => "date", "width" => 250],
            ["field" => "UnitVIN", "title" => "No Rangka", "width" => 150],
            ["field" => "UnitEngineNumber", "title" => "No Mesin", "width" => 100],
            ["field" => "LeasingVendorName", "title" => "Leasing", "width" => 250],
        ],
    ];
    $grid = new \app\components\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
    ?>
</div>
