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
            // array("field" => "Cabang", "title" => "POS / Outlet","width" => 150),
            array("field" => "SPKNumberText", "title" => "No SPK", "formatType" => "numberText"),
            array("field" => "TanggalSPK", "title" => "Tgl SPK", "formatType" => "date"),
            array("field" => "TanggalNota", "title" => "Tgl Nota", "formatType" => "date"),
            array("field" => "NoDocument", "title" => "No Dokumen"),

            array("title" => "Konsumen", "columns" => [
                ["field" => "NamaPemesan", "title" => "Nama Konsumen","width" => 250],
                ["field" => "NamaSTNK", "title" => "Nama STNK","width" => 250],
                ["field" => "Alamat", "title" => "Alamat","width" => 400],
                ["field" => "NoHandphone", "title" => "No Handphone","width" => 150],
            ]),

            array("title" => "Unit", "columns" => [
                ["field" => "NoRangka", "title" => "No Rangka","width" => 150],
                ["field" => "NoMesin", "title" => "No Mesin","width" => 100],
                ["field" => "UnitType", "title" => "Tipe Unit","width" => 250],
            ]),

            array("title" => "Leasing", "columns" => [
                ["field" => "TipePenjualan", "title" => "Tipe Penjualan","width" => 100],
                ["field" => "VendorLeasing", "title" => "Vendor Leasing","width" => 250],
            ]),

            array("title" => "Salesman", "columns" => [
                ["field" => "NamaSalesman", "title" => "Nama Sales","width" => 250],
                ["field" => "GradeSalesman", "title" => "Grade Sales","width" => 100],
                ["field" => "LeaderName", "title" => "Nama SPV","width" => 250],
                ["field" => "GradeLeader", "title" => "Grade SPV","width" => 100],
            ]),

            array("title" => "Titipan 1", "columns" => [
                ["field" => "CD1Date", "title" => "Tanggal", "formatType" => "date"],
                ["field" => "CD1Type", "title" => "Tipe","width" => 150],
                ["field" => "CD1NoPlutus", "title" => "No Plutus", "formatType" => "numberText"],
                ["field" => "CD1Nominal", "title" => "Nominal", "formatType" => "currency"],
                ["field" => "CD1Metode", "title" => "Metode","width" => 150],
            ]),

            array("title" => "Titipan 2", "columns" => [
                ["field" => "CD2Date", "title" => "Tanggal", "formatType" => "date"],
                ["field" => "CD1Type", "title" => "Tipe","width" => 150],
                ["field" => "CD1NoPlutus", "title" => "No Plutus", "formatType" => "numberText"],
                ["field" => "CD1Nominal", "title" => "Nominal", "formatType" => "currency"],
                ["field" => "CD1Metode", "title" => "Metode","width" => 150],
            ]),

            array("title" => "Titipan 3", "columns" => [
                ["field" => "CD3Date", "title" => "Tanggal", "formatType" => "date"],
                ["field" => "CD1Type", "title" => "Tipe","width" => 150],
                ["field" => "CD1NoPlutus", "title" => "No Plutus", "formatType" => "numberText"],
                ["field" => "CD1Nominal", "title" => "Nominal", "formatType" => "currency"],
                ["field" => "CD1Metode", "title" => "Metode","width" => 150],
            ]),
        ),
    );
    $grid = new \app\components\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
    ?>
</div>
