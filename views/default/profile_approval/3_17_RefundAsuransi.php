<div id="approvalApproveDisapprove_3_17_RefundAsuransi" class="d-none approvalApproveDisapprove">
    <?php
        $formParams = [
            "page" => "profile"
            ,"group" => "approval"
            ,"id" => "ApproveDisapprove_3_17_RefundAsuransi"
            ,"invalidFeedbackIsShow" => false
            ,"buttonsIsShow" => false
            ,"isReadOnly" => true
            ,"ajaxJSIsRender" => false
        ];
        $form = new \app\pages\Form($formParams);
        $form->begin();
        $form->addHtml("<div><h6>PROFIL SPK</h6></div>");
        $form->addColumn(2);
            $form->addField(["labelText" => "Tanggal Nota", "inputName" => "InvoiceDate", "inputCol" => 2]);
            $form->addField(["labelText" => "POS", "inputName" => "POSName", "inputCol" => 6]);
            $form->addField(["labelText" => "#SPK", "inputName" => "SPKNumberText", "inputCol" => 4]);
            $form->addField(["labelText" => "Refund Asuransi", "inputName" => "RefundAsuransi", "inputType" => "kendoNumericTextBox", "numericTypeDetail" => "currency"]);
        $form->nextColumn();
            $form->addField(["labelText" => "Kendaraan", "inputName" => "VehicleGroupType"]);
            $form->addField(["labelText" => "#Rangka", "inputName" => "UnitVIN", "inputCol" => 4]);
            $form->addField(["labelText" => "Konsumen", "inputName" => "CustomerName"]);
            $form->addField(["labelText" => "A/N STNK", "inputName" => "STNKCustomerName"]);
        $form->endColumn();
        $form->addField(["labelText" => "Leasing", "inputName" => "LeasingName"]);

        $form->addHtml("<br/><div><h6>PPH 23</h6></div>");
        $form->addColumn(2);
            $form->addField(["labelText" => "Waktu Transaksi", "inputName" => "DateTime", "inputCol" => 4]);
            $form->addField(["labelText" => "Nominal", "inputName" => "Nominal", "inputType" => "kendoNumericTextBox", "numericTypeDetail" => "currency"]);
            $form->nextColumn();
            $form->addField(["labelText" => "#Bukti Potong", "inputName" => "ReferenceNumber1", "inputCol" => 6]);
            $form->addField(["labelText" => "No Dokumen", "inputName" => "NumberText", "inputCol" => 4]);
        $form->endColumn();

        $form->addHtml("<br/><div><h6>KETERANGAN TRANSAKSI</h6></div>");
        $form->addField(["labelIsShow" => false, "inputName" => "Description", "inputType" => "textarea", "textareaRow" => 3]);
        $form->end();
        $form->render();
    ?>
</div>

