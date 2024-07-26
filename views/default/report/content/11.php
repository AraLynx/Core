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
            array("title" => "POS / Outlet", "width" => 250, "template" => "#= BranchAlias #, #= POSName #"),
            array("field" => "CompleteDateTime", "title" => "Tanggal", "formatType" => "date"),
            array("field" => "PKBNumberText", "title" => "No Transaksi", "formatType" => "numberText"),
            array("field" => "Type", "title" => "Tipe (WalkIn/DMS/BIB)", "width" => 120),
            array("field" => "VehiclePoliceNumber", "title" => "No Polisi", "width" => 100),

            array("field" => "SrvNonOPLDPP", "title" => "Jasa Non OPL","formatType" => "currency"),
            array("field" => "SrvOPLDPP", "title" => "Jasa OPL","formatType" => "currency"),
            array("field" => "SpGenuineDPP", "title" => "Part Genuine","formatType" => "currency"),
            array("field" => "SpBahanDPP", "title" => "Bahan","formatType" => "currency"),
            array("field" => "SpCostHPP", "title" => "Bahan Pembantu","formatType" => "currency"),
            array("field" => "SpLainDPP", "title" => "Part Lokal","formatType" => "currency"),
            array("field" => "SpOPLDPP", "title" => "Part OPL","formatType" => "currency"),

            array("field" => "VehicleVIN", "title" => "No Rangka", "width" => 150),
            array("field" => "VehicleEngineNumber", "title" => "No Mesin", "width" => 100),
            array("title" => "Customer", "width" => 350, "template" => "#= CustomerTitle # #= CustomerName #"),
        ),
    );
    $grid = new \app\components\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
    ?>
</div>
