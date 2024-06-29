<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
    $form->addColumn([3,9]);
        $form->addField(["labelText" => "Type", "labelCol" => 4, "inputType" => "kendoDropDownList", "selectFilter" => false, "selectOptions" => $selectOptions["_21_ReferenceTypeIds"], "inputName" => "ReferenceTypeId", "required" => true]);
    $form->nextColumn();
        $form->addField(["labelText" => "Invoice Periode", "inputName" => "InvoiceDate", "inputType" => "kendoDatePicker_range", "required" => true]);
    $form->endColumn();
?>
