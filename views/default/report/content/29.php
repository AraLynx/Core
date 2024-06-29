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
            array("field" => "UnitKepemilikan", "title" => "Unit Kepemilikan","width" => 150),
            array("field" => "TipeKendaraan","title" => "Tipe Kendaraan","width" => 250),
            array("field" => "Warna","width" => 130),
            array("field" => "NoRangka","title" => "No Rangka","width" => 150),
            array("field" => "NoMesin","title" => "No Mesin","width" => 120),
            array("field" => "Status","width" => 110),
            array("field" => "Lokasi","width" => 250),
            array("field" => "Umur","formatType" => "numeric"),
            array("field" => "Free","width" => 75, "attributes" => ["class" => "text-center"]),
            array("field" => "Booked","width" => 150),
            array("field" => "CalonPelanggan", "title" => "Calon Pelanggan", "width" => 150),
            array("field" => "Salesman","width" => 150)
        ),
    );
    $grid = new \app\pages\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
    ?>
</div>
