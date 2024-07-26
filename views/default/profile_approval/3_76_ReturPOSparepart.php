<div id="approvalApproveDisapprove_3_76_ReturPOSparepart" class="d-none approvalApproveDisapprove">
    <div class="desktop d-none d-lg-block">
        <!-- DESKTOP LAYOUT -->
        <div id='returnEditReturnDivReturn'>
            <h5>Profil Retur</h5>
            <?php
                $formParams = [
                    "page" => "profile"
                    ,"group" => "approval"
                    ,"id" => "ApproveDisapprove_3_76_ReturPOSparepart"
                    ,"invalidFeedbackIsShow" => false
                    ,"buttonsIsShow" => false
                    ,"isReadOnly" => true
                    ,"ajaxJSIsRender" => false
                ];
                $form = new \app\components\Form($formParams);
                $form->begin();
                    $form->addField(["labelText" => "POS", "inputName" => "POSName"]);
                    $form->addField(["labelText" => "Vendor", "inputName" => "PartnerName"]);
                    $form->addField(["labelText" => "Tanggal", "inputName" => "Date"]);
                    $form->addField(["labelText" => "No Retur", "inputName" => "DocumentNumber"]);
                    $form->addField(["labelText" => "DPP", "inputName" => "DPP", "inputType" => "kendoNumericTextBox", "numericTypeDetail" => "currency"]);
                    $form->addColumn([3,9]);
                        $form->addField(["labelText" => "PPN", "labelCol" => 4, "inputName" => "PPNPercentage", "inputType" => "kendoDropDownList", "selectOptions" => [[0,"TANPA PPN"],[11,"PPN 11%",true],[10,"PPN 10%"]]]);
                    $form->nextColumn();
                        $form->addField(["labelIsShow" => false, "inputName" => "PPNNominal", "inputType" => "kendoNumericTextBox","numericTypeDetail" => "currency"]);
                    $form->endColumn();
                    $form->addField(["labelText" => "Total", "inputName" => "Total", "inputType" => "kendoNumericTextBox", "numericTypeDetail" => "currency"]);
                $form->end();
                $form->render();
            ?>
        </div>
        <div id='returnEditReturnDivReturnItems'>
            <h5>List Sparepart</h5>
            <?php
                $gridParams = [
                    "page" => "profile",
                    "group" => "approval",
                    "id" => "ApproveDisapprove_3_76_ReturPOSparepartItems",
                    "columns" => [
                        ["formatType" => "rowNumber"],
                        //["field" => "Action","title" => " ","formatType" => "action"],
                        ["field" => "PurchaseOrderProfile","title" => "Purchase Order","width" => 200],
                        ["field" => "SparepartProfile","title" => "Sparepart","width" => 200],
                        ["field" => "GRProfile","title" => "Good Receive","width" => 200],
                        ["field" => "ReturnQuantity","title" => "Jumlah Retur", "formatType" => "numeric","width" => 100],
                        ["field" => "ReturnValue","title" => "Nilai DPP", "formatType" => "currency"],
                    ],
                ];
                $grid = new \app\components\KendoGrid($gridParams);
                $grid->begin();
                $grid->end();
                $grid->render();
            ?>
        </div>
    </div>
    <div class="mobile d-lg-none">
        MOBILE LAYOUT NOT YET AVAILABLE
        <!-- MOBILE LAYOUT -->
    </div>
</div>
