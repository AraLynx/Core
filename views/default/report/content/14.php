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
            array("field" => "CBPName", "title" => "POS / Outlet", "width" => 250),
            array("field" => "NumberText", "title" => "No. PKB", "formatType" => "numberText"),
            array("field" => "UEDate", "title" => "Tanggal UE", "formatType" => "date"),

            array("title" => "Sparepart", "columns" => array(
                array("field" => "SparepartCode", "title" => "Kode", "width" => 150),
                array("field" => "SparepartName", "title" => "Nama", "width" => 250),
            )),

            array("field" => "PRQuantity", "title" => "GI Qty", "formatType" => "dec", "template" => "#= PRQuantity # #= PRUnit #"),
            array("field" => "COGS", "formatType" => "currency"),
            array("title" => " "),
        ),
    );
    $grid = new \app\pages\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
    ?>
</div>
