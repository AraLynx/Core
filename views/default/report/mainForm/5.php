<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
    $form->addColumn(2);
        $form->addField(["labelText" => "Click Posting", "inputType" => "kendoDatePicker_range", "inputName" => "Date", "required" => true]);
        $form->addField(["labelText" => "No SPK", "inputName" => "SPKNumber", "inputCol" => 6]);
    $form->nextColumn();
        $form->addField(["labelText" => "No Dokumen", "inputName" => "DocumentNumber", "inputCol" => 6]);
        $form->addField(["labelText" => "No Referensi", "inputName" => "ReferenceNumber", "inputCol" => 6]);
    $form->endColumn();
?>
