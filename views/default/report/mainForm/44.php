<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
    $form->addField(["labelText" => "Date", "inputName" => "Date", "inputType" => "kendoDatePicker_range", "required" => true]);
?>
