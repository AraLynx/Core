<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
    $form->addField(["labelText" => "Tanggal Nota", "inputName" => "PKBCompleteDate", "inputType" => "kendoDatePicker_range", "required" => true]);

?>
