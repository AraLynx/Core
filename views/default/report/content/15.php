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
            array("field" => "CBPName", "title" => "POS / Outlet", "width" => 200, "formatType" => "text"),
            array("field" => "NumberText", "title" => "No. DS", "formatType" => "numberText"),
            array("field" => "DSDate", "title" => "Tanggal DS", "formatType" => "date"),
            array("field" => "Customer", "title" => "Konsumen", "width" => 300),
            array("field" => "Sparepart", "title" => "Sparepart","formatType" => "currency"),
            array("title" => " "),
        ),
    );
    $grid = new \app\components\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
    ?>
</div>
