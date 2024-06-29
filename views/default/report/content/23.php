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
            array("field" => "CompanyAlias", "title" => "PT", "width" => 70),
            array("field" => "BranchAlias", "title" => "Cabang", "width" => 90),
            array("field" => "POSName", "title" => "POS", "width" => 180),
            array("field" => "SPKCompleteDate", "title" => "Tgl Nota", "formatType" => "date"),
            array("field" => "SPKNumberText", "title" => "No SPK", "formatType" => "numberText" ),
            array("field" => "CustomerName", "title" => "Nama Konsumen"),
            array("field" => "VehicleGroupName", "title" => "Group"),
            array("field" => "VehicleTypeName", "title" => "Type"),
            array("field" => "UnitVIN", "title" => "No Rangka", "width" => 180),
            array("field" => "UnitEngineNumber", "title" => "No Mesin", "width" => 165),
            array("field" => "ClaimProgramTypeName", "title" => "Claim Program"),
            array("field" => "ClaimDate", "title" => "Tgl Claim", "formatType" => "date"),
            array("field" => "ClaimNumberText", "title" => "No Claim", "formatType" => "numberText"),
            array("field" => "ClaimNominal", "title" => "Nominal", "formatType" => "currency"),
            array("field" => "LoanPaymentSaldo", "title" => "Saldo", "formatType" => "currency"),
            array("field" => "LoanPaymentDate", "title" => "Tgl Pelunasan", "formatType" => "date"),
            array("field" => "LoanPaymentReferenceNumber", "title" => "No Ref Pelunasan", "width" => 120),
        ),
    );
    $grid = new \app\pages\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
    ?>
</div>
