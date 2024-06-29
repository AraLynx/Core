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

            ["field" => "CBPName", "title" => "Cabang", "width" => 175],
            ["field" => "SPKDistributionNumberText", "title" => "No. Distribusi", "formatType" => "invoiceNumberText"],
            ["field" => "DistributionDate", "title" => "Tgl Distribusi", "formatType" => "date"],
            ["field" => "LeadDate", "title" => "Telat (hari)", "formatType" => "numeric"],
            ["field" => "SPKNumberText", "title" => "No. SPK", "formatType" => "numberText"],
            ["field" => "TeamLeaderEmployeeId", "title" => "NIK TL", "width" => 100, "attributes" => ["class" => "text-end"]],
            ["field" => "TeamLeaderEmployeeName", "title" => "Nama TL", "width" => 250],
            ["field" => "SalesmanEmployeeId", "title" => "NIK Sales", "width" => 100, "attributes" => ["class" => "text-end"]],
            ["field" => "SalesmanEmployeeName", "title" => "Nama Sales", "width" => 250],
        ],
    ];
    $grid = new \app\pages\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
    ?>
</div>
