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
            array("field" => "DateTime", "title" => "Tanggal & Waktu", "formatType" => "dateTime"),
            array("field" => "TransactionName", "title" => "Kegiatan"),
            array("field" => "ReferenceNumber", "title" => "No Referensi"),
            array("title" => "Lokasi", "template" => "#= LocationPartnerType #<br/>#= LocationPartner #"),
            array("field" => "Status", "title" => "Status"),
        ),
    );
    $grid = new \app\pages\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
    ?>
</div>
