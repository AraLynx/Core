<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
    $form->addField(["labelText" => "Tanggal Posting", "inputName" => "Periode", "inputType" => "kendoDatePicker_range", "required" => true]);
?>
