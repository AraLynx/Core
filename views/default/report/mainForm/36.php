<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
        $form->addColumn([6,2,4]);
            $form->addField(["labelText" => "GR Date", "inputName" => "GRDate", "inputType" => "kendoDatePicker_range", "required" => true, "labelCol" => 2]);
        $form->nextColumn();
            $form->addField(["labelIsShow" => false, "inputType" => "kendoDropDownList", "selectFilter" => false, "selectOptions" => $selectOptions["_36_UnitFilter"], "inputName" => "UnitIdentityType"]);
        $form->nextColumn();
            $form->addField(["labelIsShow" => false,"inputName" => "UnitIdentityValue", "inputPlaceHolder" => "Masukan Nomor Mesin Atau VIN"]);
        $form->endColumn();

        $form->addColumn(2);
            $form->addField(["labelText" => "Caroserie No", "inputName" => "CaroserieNumber", "inputPlaceHolder" => "Masukan Nomor Karoseri"]);
        $form->nextColumn();
            $form->addField(["labelText" => "PO Number.", "inputName" => "PONumber", "inputPlaceHolder" => "Masukan Nomor PO", "labelCol" => 4]);
        $form->endColumn();
?>