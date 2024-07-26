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
            ["field" => "Company", "title" => "Company", "width" => 200],
            ["field" => "Branch", "title" => "Branch", "width" => 200],
            ["field" => "POS", "title" => "POS", "width" => 200],
            ["field" => "Brand", "title" => "Brand", "width" => 100],

            ["field" => "TanggalTransaksi", "title" => "Tanggal Transaksi", "formatType" => "date"],
            ["field" => "NoTransaksi", "title" => "No Transaksi", "formatType" => "numberText"],
            ["field" => "Type", "title" => "Group", "width" => 100],
            ["field" => "Group", "title" => "Sub Group", "width" => 100],
            ["field" => "Code", "title" => "Code", "width" => 150],
            ["field" => "Sparepart", "title" => "Sparepart", "width" => 250],

            ["field" => "Capital", "title" => "Capital (Rp)","formatType" => "currency"],
            ["field" => "Sell", "title" => "Sell (Rp)","formatType" => "currency"],
            ["field" => "Quantity", "title" => "Qty GI", "formatType" => "numeric"],
            ["field" => "Unit", "title" => "Unit", "width" => 100],
            ["field" => "Category", "title" => "Category", "width" => 100],
            ["field" => "Warehouse", "title" => "Warehouse", "width" => 200],
            ["field" => "Rack", "title" => "Rack", "width" => 150],
            ["field" => "Remark", "title" => "Remark", "width" => 100],
        ],
    ];
    $grid = new \app\components\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
    ?>
</div>
