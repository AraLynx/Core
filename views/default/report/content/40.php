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
            ["field" => "NumberText", "title" => "No SPK", "formatType" => "numberText"],
            ["field" => "InvoiceDate", "title" => "Tgl. Nota", "formatType" => "date"],
            ["field" => "Customer", "title" => "Nama", "formatType" => "date", "width" => 250],
            ["field" => "UnitVIN", "title" => "No Rangka", "width" => 150],
            ["field" => "UnitEngineNumber", "title" => "No Mesin", "width" => 100],
            ["field" => "VehicleType", "title" => "Model", "width" => 200],

            ["field" => "LeasingVendorName", "title" => "Leasing", "width" => 250],
            ["field" => "OTRPrice", "title" => "Harga OTR", "formatType" => "currency"],
            ["field" => "Tenor", "title" => "Tenor", "width" => 100],

            ["title" => "Tipe Asuransi","columns" => [
                ["field" => "LeasingInsuranceAllRisk", "title" => "All Risk", "formatType" => "numeric"],
                ["field" => "LeasingInsuranceTLO", "title" => "TLO", "formatType" => "numeric"],
            ]],
            ["field" => "LeasingARInsuranceRefund", "title" => "Nilai Refund", "formatType" => "currency"],

            ["title" => "Bank","columns" => [
                ["field" => "BankDate", "title" => "Tgl", "formatType" => "date"],
                ["field" => "BankReferenceNumber", "title" => "No Referensi", "width" => 150],
                ["field" => "BankNominal", "title" => "Jumlah", "formatType" => "currency"],
            ]],
            ["title" => "PPH23","columns" => [
                ["field" => "PPH23Date", "title" => "Tgl", "formatType" => "date"],
                ["field" => "PPH23ReferenceNumber", "title" => "No Referensi", "width" => 150],
                ["field" => "PPH23Nominal", "title" => "Jumlah", "formatType" => "currency"],
            ]],
            ["field" => "Balance", "title" => "Saldo", "formatType" => "currency"],
        ],
    ];
    $grid = new \app\components\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
    ?>
</div>
