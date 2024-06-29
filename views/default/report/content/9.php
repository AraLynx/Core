<?php
?>
<div id='reportDiv_<?php echo $reportId;?>' class='reportDiv d-none'>
    <?php
    $gridParams = array(
        "page" => "report",
        "group" => "report",
        "id" => "_{$reportId}",
        "toolbarString" => "<div class=\'btn btn-secondary align-middle\' onclick=\'reportGenerateExcelPrepareData({$reportId})\'>Export to Excel</div>",
        "columns" => [
            ["formatType" => "rowNumber"],
            ["field" => "CDDate", "title" => "Tgl Setor", "formatType" => "date"],
            ["field" => "CDBranchName", "title" => "Cabang", "width" => 150],
            ["field" => "CDCustomerName", "title" => "Nama Konsumen", "width" => 200],
            ["field" => "CDCustomerVehicleVIN", "title" => "No Rangka", "width" => 170],
            ["field" => "CDCustomerVehicleEngineNumber", "title" => "No Mesin", "width" => 100],
            ["field" => "CDNominal", "title" => "Nominal", "formatType" => "currency"],
            ["field" => "CDCetakanNumber", "title" => "No TTS", "width" => 100],

            ["field" => "PKBNumberText1", "title" => "No PKB 1", "formatType" => "numberText"],
            ["field" => "UsageNominal1", "title" => "Nominal", "formatType" => "currency"],
            ["field" => "PKBNumberText2", "title" => "No PKB 2", "formatType" => "numberText"],
            ["field" => "UsageNominal2", "title" => "Nominal", "formatType" => "currency"],
            ["field" => "PKBNumberText3", "title" => "No PKB 3", "formatType" => "numberText"],
            ["field" => "UsageNominal3", "title" => "Nominal", "formatType" => "currency"],

            ["field" => "CDBalance", "title" => "SisaSaldo", "formatType" => "currency"],
            ["field" => "CDSellerName", "title" => "Nama Penjual", "width" => 200],
            ["field" => "CDDepositor", "title" => "Nama Penyetor", "width" => 200],
            ["field" => "CDMethod", "title" => "Jenis Setoran", "width" => 200],
        ],
    );
    $grid = new \app\pages\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
    ?>
</div>
