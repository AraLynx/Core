<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
    $form->addField(["labelText" => "Periode", "inputName" => "Periode", "inputType" => "kendoDatePicker_range", "required" => true]);
    $form->addField(["labelText" => "Kode", "inputName" => "SparepartCode", "inputCol" => 2]);
    $form->addField(["labelText" => "Sparepart", "inputName" => "SparepartName"]);
?>
