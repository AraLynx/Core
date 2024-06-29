<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
    $form->addColumn([5,3,4]);
        $form->addField(["labelText" => "Invoice Date", "inputName" => "InvoiceDate", "inputType" => "kendoDatePicker_range", "required" => true]);
    $form->nextColumn();
        $form->addField(["labelText" => "Type", "inputType" => "kendoDropDownList", "inputName" => "VehicleGroupId",  "inputOnChange" => "reportGetReport_VehicleGroupIdChange"]);
    $form->nextColumn();
        $form->addField(["labelText" => "Suffix", "inputType" => "kendoDropDownList", "inputName" => "VehicleTypeId"]);
    $form->endColumn();
?>
