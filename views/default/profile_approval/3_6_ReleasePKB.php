<div id="approvalApproveDisapprove_3_6_ReleasePKB" class="d-none approvalApproveDisapprove">
    <div class="desktop d-none d-lg-block">
        <!-- DESKTOP LAYOUT -->
        <div>
            <h5 class="mb-2">Profil PKB</h5>
            <?php
                $formParams = [
                    "page" => "profile"
                    ,"group" => "approval"
                    ,"id" => "ApproveDisapprove_3_6_ReleasePKB"
                    ,"invalidFeedbackIsShow" => false
                    ,"buttonsIsShow" => false
                    ,"isReadOnly" => true
                    ,"ajaxJSIsRender" => false
                ];
                $form = new \app\pages\Form($formParams);
                $form->begin();
                    $form->addColumn([5,7]);
                        $form->setDefaultLabelCol(3);
                        $form->addField(["labelText" => "No PKB", "inputName" => "NumberText"]);
                        $form->addField(["labelText" => "Cabang / POS", "inputName" => "CBPName"]);
                        $form->addField(["labelText" => "Unit Entry", "inputName" => "PKBDate"]);
                        $form->addField(["labelText" => "Retail", "inputName" => "TotalRetail", "inputType" => "kendoNumericTextBox", "numericTypeDetail" => "currency"]);
                        $form->addField(["labelText" => "Diskon", "inputName" => "TotalDiscount", "inputType" => "kendoNumericTextBox", "numericTypeDetail" => "currency"]);
                        $form->addField(["labelText" => "DPP (ex. pajak)", "inputName" => "TotalDPP", "inputType" => "kendoNumericTextBox", "numericTypeDetail" => "currency"]);
                    $form->nextColumn();
                        $form->setDefaultLabelCol(2);
                        $form->addField(["labelText" => "Konsumen", "inputName" => "Customer"]);
                        $form->addField(["labelText" => "KTP / NPWP", "inputName" => "CustomerID"]);
                        $form->addField(["labelText" => "Kendaraan", "inputName" => "VehicleGroup"]);
                        $form->addField(["labelText" => "Rangka / Mesin", "inputName" => "VehicleID"]);
                        $form->addField(["labelText" => "No Polisi", "inputName" => "VehiclePoliceNumber"]);
                        $form->addField(["labelText" => "Keluhan", "inputName" => "Complaint"]);
                    $form->endColumn();
                $form->end();
                $form->render();
            ?>
            <h5 class="mt-3 mb-2">Jasa & Sparepart</h5>
            <?php
                $gridParams = [
                    "page" => "profile",
                    "group" => "approval",
                    "id" => "ApproveDisapprove_3_6_ReleasePKBItems",
                    "columns" => [
                        ["formatType" => "rowNumber"],
                        ["field" => "ChargeTo","title" => "Charge To","width" => 150],
                        ["field" => "Code","title" => "Kode","width" => 150],
                        ["field" => "Name","title" => "Nama","width" => 250],
                        ["field" => "Qty","title" => "Jumlah","width" => 100],
                        ["field" => "Retail","title" => "Retail", "formatType" => "currency"],
                        ["field" => "Discount","title" => "Diskon", "formatType" => "currency"],
                        ["field" => "SubTotal","title" => "DPP", "formatType" => "currency"],
                        ["title" => ""],
                    ],
                ];
                $grid = new \app\pages\KendoGrid($gridParams);
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
