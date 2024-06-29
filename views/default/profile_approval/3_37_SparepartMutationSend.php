<div id="approvalApproveDisapprove_3_37_SparepartMutationSend" class="d-none approvalApproveDisapprove">
    <div class="desktop d-none d-lg-block">
        <!-- DESKTOP LAYOUT -->
        <div id='sendEditSparepartMutationDivSparepartMutation'>
            <h5 class="mb-2">Profil Mutasi Sparepart</h5>
            <?php
                $formParams = [
                    "page" => "profile"
                    ,"group" => "approval"
                    ,"id" => "ApproveDisapprove_3_37_SparepartMutationSend"
                    ,"invalidFeedbackIsShow" => false
                    ,"buttonsIsShow" => false
                    ,"isReadOnly" => true
                    ,"ajaxJSIsRender" => false
                ];
                $form = new \app\pages\Form($formParams);
                $form->begin();
                    $form->addColumn([4,8]);
                        $form->addField(["labelText" => "POS Asal", "labelCol" => 3, "inputName" => "OriginPOSName"]);
                        $form->addField(["labelText" => "POS Tujuan", "labelCol" => 3, "inputName" => "DestinationPOSName"]);
                    $form->nextColumn();
                        $form->addField(["labelText" => "Tgl. Mutasi", "inputName" => "Date", "inputType" => "kendoDatePicker"]);
                        $form->addField(["labelText" => "No. Mutasi", "inputName" => "NumberText"]);
                    $form->endColumn();
                    
                    $form->addField(["labelText" => "Keterangan", "inputName" => "Description"]);

                    $form->addColumn([4,8]);
                        $form->addField(["labelText" => "Tgl. Pengiriman", "labelCol" => 3, "inputName" => "DeliveryDate", "inputType" => "kendoDatePicker"]);
                    $form->nextColumn();
                        $form->addField(["labelText" => "PIC Pengirim", "inputName" => "DeliveryPICName"]);
                    $form->endColumn();

                    $form->addField(["labelText" => "Ket. Pengiriman", "inputName" => "DeliveryGeneralNotes"]);
                $form->end();
                $form->render();
            ?>
        </div>
        <div id='sendEditSparepartMutationDivSparepartMutationItems'>
            <h5 class="mt-3 mb-2">List Sparepart</h5>
            <?php
                $gridParams = [
                    "page" => "profile",
                    "group" => "approval",
                    "id" => "ApproveDisapprove_3_37_SparepartMutationSendItems",
                    "columns" => [
                        ["formatType" => "rowNumber"],
                        //["field" => "Action","title" => " ","formatType" => "action"],
                        ["field" => "SparepartGroupProfile","title" => "Tipe","width" => 75],
                        ["field" => "SparepartGroup2Profile","title" => "Grup","width" => 75],
                        ["field" => "SparepartGroup3Profile","title" => "SGrup","width" => 75],
                        ["field" => "SparepartCode","title" => "Kode","width" => 150],
                        ["field" => "SparepartName","title" => "Sparepart","width" => 350],
                        ["field" => "OriginQuantity","title" => "Jumlah", "formatType" => "decimal","width" => 100],
                        ["field" => "OriginRackName","title" => "Rak","width" => 250],
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
