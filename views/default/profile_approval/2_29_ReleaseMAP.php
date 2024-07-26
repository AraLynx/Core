<div id="approvalApproveDisapprove_2_29_ReleaseMAP" class="d-none approvalApproveDisapprove">
    <div class="desktop d-none d-lg-block">
        <!-- DESKTOP LAYOUT -->
        <div id=''>
            <h6>Activity Profile</h6>
            <?php
                $formParams = [
                    "page" => "profile"
                    ,"group" => "approval"
                    ,"id" => "ApproveDisapprove_2_29_ReleaseMAP"
                    ,"invalidFeedbackIsShow" => false
                    ,"buttonsIsShow" => false
                    ,"isReadOnly" => true
                    ,"ajaxJSIsRender" => false
                ];
                $form = new \app\components\Form($formParams);
                $form->begin();
                    $form->addColumn([5,5,2]);
                        $form->addField(["labelText" => "Cabang", "labelCol" => 4, "inputName" => "Branch"]);
                        $form->addField(["labelText" => "Branch Manager","labelCol" => 4, "inputName" => "BranchManagerName"]);
                    $form->nextColumn();
                        $form->addField(["labelText" => "No. Dokumen", "inputName" => "DocumentNumber", "inputCol" => 6]);
                        $form->addField(["labelText" => "Periode", "inputName" => "DateApply", "inputCol" => 6]);
                    $form->endColumn();
                    $form->addColumn([5,5,2]);
                    $form->addField(["labelText" => "Total Biaya", "inputName" => "Subtotal", "inputType" => "kendoNumericTextBox","numericTypeDetail" => "currency","labelCol" => 4]);
                    $form->nextColumn();
                    $form->endColumn();
                    $form->addHtml("<hr/>");
                $form->end();
                $form->render();
            ?>
        </div>
        <div id=''>
            <h6 class="mb-2">Activity Detail</h6>
            <?php
                $gridParams = [
                    "page" => "profile",
                    "group" => "approval",
                    "id" => "ApproveDisapprove_2_29_ReleaseMAPItems",
                    "pageable" => false,
                    "columns" => array(
                        ["formatType" => "rowNumber"],
                        ["field" => "PICProfile","title" => "Profil PIC", "width" => 200],
                        ["field" => "ActivityDateTime","title" => "Detail Aktivitas", "width" => 150],
                        ["field" => "DetailActivity","title" => "Tipe Aktivitas", "width" => 350],
                        ["field" => "DetailBudget","title" => "Rincian Biaya", "width" => 200],
                        ["field" => "CalculateBudget","title" => "Subtotal Biaya", "width" => 200],
                    ),
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
