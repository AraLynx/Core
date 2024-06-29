<div id="approvalApproveDisapprove_3_44_ReleaseSPK" class="d-none approvalApproveDisapprove">
    <div class="desktop d-none d-lg-block">
        DESKTOP LAYOUT NOT YET AVAILABLE
        <!-- DESKTOP LAYOUT -->
    </div>
    <div class="mobile d-lg-none">
        <!-- MOBILE LAYOUT -->
        <?php
        $formParams = [
            "page" => "profile"
            ,"group" => "approval"
            ,"id" => "ApproveDisapprove_3_44_ReleaseSPKMobile"
            ,"invalidFeedbackIsShow" => false
            ,"buttonsIsShow" => false
            ,"isReadOnly" => true
            ,"ajaxJSIsRender" => false
        ];
        $form = new \app\pages\Form($formParams);

        $form->begin();
            $form->addField(["labelText" => "SPK", "inputName" => "SPK"]);

            $form->addField(["labelText" => "OTR", "inputName" => "OTR"]);
            $form->addField(["labelText" => "Transaction", "inputName" => "Transaction"]);
            $form->addField(["labelText" => "AR", "inputName" => "AR"]);
            $form->addField(["labelText" => "Payment In", "inputName" => "Payment"]);

            $form->addField(["labelText" => "Customer", "inputName" => "Customer"]);

            $form->addField(["labelText" => "Unit Type", "inputName" => "Vehicle"]);
            $form->addField(["labelText" => "Unit Number", "inputName" => "Unit"]);

            $form->addField(["labelText" => "Salesman", "inputName" => "Sales"]);
        $form->end();
        $form->render();
        ?>
    </div>
</div>
