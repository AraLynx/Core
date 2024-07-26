<div id="approvalApproveDisapprove_<?php echo $applicationId;?>_<?php echo $pageId;?>_ReleasePO" class="d-none approvalApproveDisapprove">
    <div class="desktop d-none d-lg-block">
        <!-- DESKTOP LAYOUT -->
        <?php
        $formParams = [
            "page" => "profile"
            ,"group" => "approval"
            ,"id" => "ApproveDisapprove_{$applicationId}_{$pageId}_ReleasePO"
            ,"invalidFeedbackIsShow" => false
            ,"buttonsIsShow" => false
            ,"isReadOnly" => true
            ,"ajaxJSIsRender" => false
        ];
        $form = new \app\components\Form($formParams);
        $form->begin();
            $form->addColumn(2);
                $form->addHtml("<h5>PO Profile</h5>");
                $form->addField(["labelText" => "Branch", "inputName" => "CBP"]);
                $form->addField(["labelText" => "PO Date", "inputName" => "Date", "inputCol" => 3]);
                $form->addField(["labelText" => "PO Number", "inputName" => "NumberText"]);
                $form->addField(["labelText" => "General Notes", "inputName" => "GeneralNotes", "inputType" => "textarea", "textareaShowCounter" => false, "textareaRow" => 4]);
                $form->addField(["labelText" => "Internal Notes", "inputName" => "InternalNotes", "inputType" => "textarea", "textareaShowCounter" => false, "textareaRow" => 4]);
            $form->nextColumn(2);
                $form->addHtml("<h5>Vendor Profile</h5>");
                $form->addField(["labelText" => "Vendor", "inputName" => "Partner"]);
                $form->addField(["labelText" => "NPWP", "inputName" => "PartnerNPWPPKPNumber"]);
                $form->addField(["labelText" => "Address", "inputName" => "PartnerAddress", "inputType" => "textarea", "textareaShowCounter" => false, "textareaRow" => 3]);
                $form->addField(["labelText" => "Sales Number", "inputName" => "PartnerSONumber"]);
                $form->addField(["labelText" => "PIC", "inputName" => "PartnerPIC"]);
                $form->addField(["labelText" => "Notes", "inputName" => "PartnerNotes", "inputType" => "textarea", "textareaShowCounter" => false, "textareaRow" => 3]);
        $form->end();
        $form->render();

        echo "<br/><h5>PRODUCTS</h5>";

        $gridParams = array(
            "page" => "profile",
            "group" => "approval",
            "id" => "ApproveDisapprove_{$applicationId}_{$pageId}_ReleasePO",
            "columnMenu" => false,
            "filterable" => false,
            "sortable" => false,
            "resizable" => false,
            "height" => 300,
            "pageable" => false,

            "columns" => [
                ["field" => "POItemProfile","title" => "Product"],
                ["field" => "PPProfile","title" => "Doc. Reference"],
                ["field" => "POItemPrice","title" => "Price", "attributes" => ["class" => "text-end"],"width" => 200]
            ],
        );

        $grid = new \app\components\KendoGrid($gridParams);
        $grid->begin();
        $grid->end();
        $grid->render();
        ?>
        <p class="text-end"></p>
    </div>
    <div class="mobile d-lg-none">
        <!-- MOBILE LAYOUT -->
        <?php
        $formParams = [
            "page" => "profile"
            ,"group" => "approval"
            ,"id" => "ApproveDisapprove_{$applicationId}_{$pageId}_ReleasePOMobile"
            ,"invalidFeedbackIsShow" => false
            ,"buttonsIsShow" => false
            ,"isReadOnly" => true
            ,"ajaxJSIsRender" => false
        ];
        $form = new \app\components\Form($formParams);

        $form->begin();
            $form->addField(["labelText" => "PO", "inputName" => "PO"]);
            $form->addField(["labelText" => "Notes", "inputName" => "GeneralNotes"]);
            $form->addField(["labelIsShow" => false, "inputName" => "InternalNotes"]);
            $form->addField(["labelText" => "Vendor", "inputName" => "Partner"]);
            $form->addField(["labelText" => "Total", "inputName" => "TotalPrice"]);
        $form->end();
        $form->render();

        echo "<br/><h5>PRODUCTS</h5>";

        $gridParams = array(
            "page" => "profile",
            "group" => "approval",
            "id" => "ApproveDisapprove_{$applicationId}_{$pageId}_ReleasePOMobile",
            "columnMenu" => false,
            "filterable" => false,
            "sortable" => false,
            "resizable" => false,
            "height" => 300,
            "pageable" => false,

            "columns" => [
                ["field" => "POItemProfile","title" => "Product"],
                ["field" => "POItemPrice","title" => "Price", "attributes" => ["class" => "text-end"],"width" => 150]
            ],
        );

        $grid = new \app\components\KendoGrid($gridParams);
        $grid->begin();
        $grid->end();
        $grid->render();
        ?>
    </div>
</div>
