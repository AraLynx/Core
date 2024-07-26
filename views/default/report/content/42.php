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

            ["field" => "CBPName", "title" => "Cabang", "width" => 160],
            ["field" => "NumberText", "title" => "No. SPK", "width" => 150],
            ["field" => "NotaDate", "title" => "Tgl. Nota", "formatType" => "date"],
            ["field" => "CustomerName", "title" => "Nama Pemesan", "width" => 300],
            ["field" => "STNKCustomerName", "title" => "Nama STNK", "width" => 300],
            ["field" => "UnitVIN", "title" => "No. Rangka", "width" => 150],
            ["field" => "UnitEngineNumber", "title" => "No. Mesin", "width" => 100],
            ["field" => "UnitColor", "title" => "Warna", "width" => 150],
            ["field" => "VehicleGroup", "title" => "Model", "width" => 200],
            ["field" => "VehicleType", "title" => "Tipe", "width" => 200],
            ["field" => "LeasingVendorName", "title" => "Nama Leasing", "width" => 400],
            ["field" => "PaymentDate", "title" => "Tgl. Pelunasan", "formatType" => "date"],
            ["field" => "LoanPaymentNominal", "title" => "Nominal Pelunasan", "formatType" => "currency"],

            // ["field" => "NumberText", "title" => "No SPK", "formatType" => "numberText"],
            // ["field" => "InvoiceDate", "title" => "Tgl. Nota", "formatType" => "date"],
            // ["field" => "Customer", "title" => "Nama", "formatType" => "date", "width" => 250],
            // ["field" => "UnitVIN", "title" => "No Rangka", "width" => 150],
            // ["field" => "UnitEngineNumber", "title" => "No Mesin", "width" => 100],
            // ["field" => "LeasingVendorName", "title" => "Leasing", "width" => 250],
        ],
    ];
    $grid = new \app\components\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
    ?>
</div>
