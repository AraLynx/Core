<?php
?>
<div id='reportDiv_<?php echo $reportId;?>' class='reportDiv d-none'>
    <?php
    $gridParams = array(
        "page" => "report",
        "group" => "report",
        "id" => "_{$reportId}",
        "toolbarString" => "<div class=\'btn btn-secondary align-middle\' onclick=\'TDE.reportGenerateExcel_{$reportId}_ReportVersion.value(\"summary\");reportGenerateExcelPrepareData({$reportId})\'>Export Summary to Excel</div>"
                        ."<div class=\'btn btn-secondary align-middle\' onclick=\'TDE.reportGenerateExcel_{$reportId}_ReportVersion.value(\"detail\");reportGenerateExcelPrepareData({$reportId})\'>Export Detail to Excel</div>",
        "columns" => array(
            ["title" => "No", "formatType" => "rowNumber"],
            ["field" => "SPKNo", "title" => "No SPK", "width" => 100],
            ["field" => "RegisterDate", "title" => "Tgl Register","formatType" => "date","width" => 120],
            ["field" => "DistributionDate", "title" => "Tgl Distribusi", "formatType" => "date","width" => 120],
            ["field" => "SPKDate", "title" => "Tgl SPK", "formatType" => "date","width" => 120],
            ["field" => "Status", "title" => "Status","width" => 100],
            ["field" => "POSName", "title" => "POS", "width" => 150],
            ["title" => "Nama Konsumen", "width" => 200, "template" => "#= PelangganPanggilan # #= PelangganNama #"],
            ["title" => "Tipe Unit", "width" => 250, "template" => "#= VehicleGroup # #= VehicleType #"],
            ["field" => "TeamLeaderName", "title" => "Nama Team Leader","width" => 200],
            ["field" => "SalesName", "title" => "Nama Sales", "width" => 200],
        ),
    );
    $grid = new \app\pages\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
    ?>
</div>
