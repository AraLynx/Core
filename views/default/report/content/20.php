<?php
?>
<div id='reportDiv_<?php echo $reportId;?>' class='reportDiv d-none'>
    <?php
    $gridParams = array(
        "page" => "report",
        "group" => "report",
        "id" => "_{$reportId}",
        "toolbarString" => "<div class=\'btn btn-secondary align-middle\' onclick=\'reportGenerateExcelPrepareData({$reportId})\'>Export Table to Excel</div>"
                        ."<div class=\'btn btn-secondary align-middle\' onclick=\'reportGenerateExcelRawPrepareData({$reportId})\'>Export Raw Trasaction to Excel</div>",
        "columns" => array(
            array("title" => "No", "formatType" => "rowNumber"),
            array("title" => "POS / Outlet", "width" => 200, "template" => "#= BranchAlias #, #= POSName #"),
            array("title" => "Code", "width" => 150, "template" => "<i class=\'fa-regular fa-eye fa-fw\' role=\'button\' title=\'View Detail Transaction\' onClick=\'reportGetReport_{$reportId}_DetailPrepareData(&apos;ALL&apos;, #= SpPOSId #);\'></i> #= SparepartCode #"),
            array("field" => "SparepartName", "title" => "Sparepart", "width" => 300),
            array("field" => "S", "title" => "Start", "formatType" => "dec"),
            array("title" => "GR", "formatType" => "dec", "template" => "# if (GR != 0){# <i class=\'fa-regular fa-eye fa-fw\' role=\'button\' title=\'View Detail Good Receive\' onClick=\'reportGetReport_{$reportId}_DetailPrepareData(&apos;GR&apos;, \${SpPOSId});\'></i> \${GR} #} else {# - #} #"),
            array("title" => "GI", "formatType" => "dec", "template" => "# if (GI != 0){# <i class=\'fa-regular fa-eye fa-fw\' role=\'button\' title=\'View Detail Good Issue\' onClick=\'reportGetReport_{$reportId}_DetailPrepareData(&apos;GI&apos;, \${SpPOSId});\'></i> \${GI} #} else {# - #} #"),
            array("title" => "GI (X)", "formatType" => "dec", "template" => "# if (GIX != 0){# <i class=\'fa-regular fa-eye fa-fw\' role=\'button\' title=\'View Detail Canceled Good Issue\' onClick=\'reportGetReport_{$reportId}_DetailPrepareData(&apos;GIX&apos;, \${SpPOSId});\'></i> \${GIX} #} else {# - #} #"),
            array("title" => "MTO", "formatType" => "dec", "template" => "# if (MTO != 0){# <i class=\'fa-regular fa-eye fa-fw\' role=\'button\' title=\'View Detail Mutation Out\' onClick=\'reportGetReport_{$reportId}_DetailPrepareData(&apos;MTO&apos;, \${SpPOSId});\'></i> \${MTO} #} else {# - #} #"),
            array("title" => "MTO (X)", "formatType" => "dec", "template" => "# if (MTOX != 0){# <i class=\'fa-regular fa-eye fa-fw\' role=\'button\' title=\'View Detail Canceled Mutation Out\' onClick=\'reportGetReport_{$reportId}_DetailPrepareData(&apos;MTOX&apos;, \${SpPOSId});\'></i> \${MTOX} #} else {# - #} #"),
            array("title" => "MTO (R)", "formatType" => "dec", "template" => "# if (MTOR != 0){# <i class=\'fa-regular fa-eye fa-fw\' role=\'button\' title=\'View Detail Returned Mutation Out\' onClick=\'reportGetReport_{$reportId}_DetailPrepareData(&apos;MTOR&apos;, \${SpPOSId});\'></i> \${MTOR} #} else {# - #} #"),
            array("title" => "MTI", "formatType" => "dec", "template" => "# if (MTI != 0){# <i class=\'fa-regular fa-eye fa-fw\' role=\'button\' title=\'View Detail Mutation In\' onClick=\'reportGetReport_{$reportId}_DetailPrepareData(&apos;MTI&apos;, \${SpPOSId});\'></i> \${MTI} #} else {# - #} #"),
            array("title" => "ADJ", "formatType" => "dec", "template" => "# if (ADJ != 0){# <i class=\'fa-regular fa-eye fa-fw\' role=\'button\' title=\'View Detail Adjustment\' onClick=\'reportGetReport_{$reportId}_DetailPrepareData(&apos;ADJ&apos;, \${SpPOSId});\'></i> \${ADJ} #} else {# - #} #"),
            array("field" => "E", "title" => "End", "formatType" => "dec"),
        ),
    );
    $grid = new \app\components\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();

    $formParams = [
        "page" => "report"
        ,"group" => "report"
        ,"id" => "GetReport_{$reportId}_Detail"
        ,"isHidden" => true
    ];
    $form = new \app\components\Form($formParams);
    $form->begin();
    $form->addField(["inputName" => "PeriodeStart"]);
    $form->addField(["inputName" => "PeriodeEnd"]);
    $form->addField(["inputName" => "SparepartPOSId"]);
    $form->addField(["inputName" => "TransactionCode"]);
    $form->end();
    $form->render();

    //#region SparepartMaterialMovementDetail
        //#region GENERATE REPORT DETAIL
            $gridParams = array(
                "page" => "report",
                "group" => "report",
                "id" => "GetReport_{$reportId}_Detail",
                "height" => false,
                //"toolbarString" => "<div class=\'btn btn-secondary align-middle\' onclick=\'reportGenerateExcelPrepareData(\"SparepartMaterialMovement\")\'>Export to Excel</div>",
                "columns" => array(
                    array("title" => "No", "formatType" => "rowNumber"),
                    array("field" => "DateTime", "title" => "Date & Time", "formatType" => "dateTime"),
                    array("field" => "TransactionName", "title" => "Transaction", "width" => 120),
                    array("field" => "ReferenceNumber", "title" => "Reference Number", "width" => 200),
                    array("field" => "Quantity", "title" => "Quantity", "formatType" => "dec"),
                ),
            );
            $grid = new \app\components\KendoGrid($gridParams);
            $grid->begin();
            $grid->end();

            $windowParams = array(
                "page" => "report"
                ,"group" => "report"
                ,"id" => "GetReport_{$reportId}_Detail"
                ,"title" => "MOVEMENT DETAIL"
                ,"body" => $grid->getHtml()
                ,"width" => "670px"
            );
            $window = new \app\components\KendoWindow($windowParams);
            $window->begin();
            $window->end();
            $window->render();
        //#endregion GENERATE REPORT DETAIL
    ?>
</div>
