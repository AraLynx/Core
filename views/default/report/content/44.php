<?php
?>
<div id='reportDiv_<?php echo $reportId;?>' class='reportDiv d-none'>
    <?php
    $gridParams = [
        "page" => "report",
        "group" => "report",
        "id" => "_{$reportId}DetailInit",
        "isDetailInit" => true,
        "columns" => [
            ["field" => "No", "title" => "No", "width" => 250, "width" => 50, "attributes" => ["class" => "text-end"]],
            ["field" => "DateTime", "title" => "Tanggal", "formatType" => "dateTime"],
            ["field" => "ReferenceNumber", "title" => "No Referensi", "width" => 250],
            ["field" => "Description", "title" => "Keterangan", "width" => 400],
            ["field" => "Debit", "title" => "Debit (Rp)", "formatType" => "currency"],
            ["field" => "Credit", "title" => "Credit (Rp)", "formatType" => "currency"],
            ["field" => "Balance", "title" => "Saldo (Rp)", "formatType" => "currency"],
            ["title" => " "]
        ],
    ];
    $gridDetailInit = new \app\components\KendoGrid($gridParams);
    $gridDetailInit->begin();
    $gridDetailInitFunctionName = $gridDetailInit->end();
    $gridDetailInit->render();

    $gridParams = [
        "page" => "report",
        "group" => "report",
        "id" => "_{$reportId}",
        "toolbarString" => "<div class=\'btn btn-secondary align-middle\' onclick=\'reportGenerateExcelPrepareData({$reportId})\'>Export to Excel</div>"
            ."<div class=\'btn btn-secondary align-middle\' onclick=\'reportGeneratePrintOutPrepareData({$reportId})\'>Print Cetakan</div>",
        "detailInit" => $gridDetailInitFunctionName,//DEFAULT ""
        "columns" => [
            ["field" => "Code", "title" => "COA", "width" => 150],
            ["field" => "Name", "title" => "Bank", "width" => 250],
            ["field" => "Balance", "title" => "Saldo (Rp)", "formatType" => "currency"],
            ["title" => " "]
        ],
    ];
    $grid = new \app\components\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
    ?>
</div>
