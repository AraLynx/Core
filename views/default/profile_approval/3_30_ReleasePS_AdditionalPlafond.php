<div id="approvalApproveDisapprove_3_30_ReleasePS_AdditionalPlafond" class="d-none approvalApproveDisapprove">
    <div class="desktop d-none d-lg-block">
        <!-- DESKTOP LAYOUT -->
        <div>
            <h5 class="mb-2">Profil Part Shop</h5>
            <?php
                $formParams = [
                    "page" => "profile"
                    ,"group" => "approval"
                    ,"id" => "ApproveDisapprove_3_30_ReleasePS_AdditionalPlafond"
                    ,"invalidFeedbackIsShow" => false
                    ,"buttonsIsShow" => false
                    ,"isReadOnly" => true
                    ,"ajaxJSIsRender" => false
                ];
                $form = new \app\components\Form($formParams);
                $form->begin();
                    $form->addField(["labelText" => "No PS", "inputName" => "NumberText"]);
                    $form->addField(["labelText" => "Cabang / POS", "inputName" => "CBPName"]);
                    $form->addField(["labelText" => "Konsumen", "inputName" => "CustomerName"]);
                    $form->addField(["labelText" => "PO Number", "inputName" => "PONumber"]);
                    $form->addField(["labelText" => "Kontrak", "inputName" => "CustomerPlafond", "inputType" => "kendoNumericTextBox", "numericTypeDetail" => "currency"]);
                    $form->addField(["labelText" => "Saldo", "inputName" => "CustomerBalance", "inputType" => "kendoNumericTextBox", "numericTypeDetail" => "currency"]);
                    $form->addField(["labelText" => "Over Plafond", "inputName" => "AdditionalPlafond", "inputType" => "kendoNumericTextBox", "numericTypeDetail" => "currency"]);
                $form->end();
                $form->render();
            ?>
            <h5 class="mt-3 mb-2">Sparepart</h5>
            <?php
                $gridParams = [
                    "page" => "profile",
                    "group" => "approval",
                    "id" => "ApproveDisapprove_3_30_ReleasePS_AdditionalPlafondItems",
                    "columns" => [
                        ["formatType" => "rowNumber"],
                        ["field" => "Code","title" => "Kode","width" => 150],
                        ["field" => "Name","title" => "Nama","width" => 250],
                        ["field" => "Qty","title" => "Jumlah","width" => 100],
                        ["field" => "Retail","title" => "Retail", "formatType" => "currency"],
                        ["field" => "Discount","title" => "Diskon", "formatType" => "currency"],
                        ["field" => "SubTotal","title" => "DPP", "formatType" => "currency"],
                        ["title" => ""],
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

    <h5 class="mb-2">Profil Part Shop</h5>
        <?php
            $formParams = [
                "page" => "profile"
                ,"group" => "approval"
                ,"id" => "ApproveDisapprove_3_30_ReleasePS_AdditionalPlafondMobile"
                ,"invalidFeedbackIsShow" => false
                ,"buttonsIsShow" => false
                ,"isReadOnly" => true
                ,"ajaxJSIsRender" => false
            ];
            $form = new \app\components\Form($formParams);
            $form->begin();
                $form->addField(["labelText" => "No PS", "inputName" => "NumberText"]);
                $form->addField(["labelText" => "Cabang / POS", "inputName" => "CBPName"]);
                $form->addField(["labelText" => "Konsumen", "inputName" => "CustomerName"]);
                $form->addField(["labelText" => "PO Number", "inputName" => "PONumber"]);
                $form->addField(["labelText" => "Plafond Kontrak", "inputName" => "CustomerPlafond", "inputType" => "kendoNumericTextBox", "numericTypeDetail" => "currency"]);
                $form->addField(["labelText" => "Saldo Plafond", "inputName" => "CustomerBalance", "inputType" => "kendoNumericTextBox", "numericTypeDetail" => "currency"]);
                $form->addField(["labelText" => "Over Plafond", "inputName" => "AdditionalPlafond", "inputType" => "kendoNumericTextBox", "numericTypeDetail" => "currency"]);
            $form->end();
            $form->render();
        ?>
    </div>
</div>
