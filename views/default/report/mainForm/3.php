<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
        $form->addField(["labelText" => "Tanggal Nota", "inputName" => "InvoiceDate", "inputType" => "kendoDatePicker_range", "required" => true]);
?>
