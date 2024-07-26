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
            ["field" => "CBPName", "title" => "POS / Outlet", "width" => 250],
            ["field" => "SAEmployeeName", "title" => "Nama Service Advisor", "width" => 275],
            ["field" => "PKBCount", "title" => "Jumlah PKB", "formatType" => "numeric"],
            ["field" => "Service", "title" => "Jasa", "formatType" => "currency"],
            ["field" => "Genuine", "title" => "Part Genuine", "formatType" => "currency"],
            ["field" => "NonGenuine", "title" => "Non Genuine", "formatType" => "currency"],
            ["field" => "Total", "title" => "Total", "formatType" => "currency"],
        ],
    ];
    $grid = new \app\components\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
    ?>
</div>
