<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
    $form->addField(["labelText" => "Periode", "inputName" => "Periode", "inputType" => "kendoDatePicker_range", "required" => true]);
?>
