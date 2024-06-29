<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
    $form->addColumn([5,5,2]);
        $form->addField(["labelText" => "Tanggal SPK", "inputType" => "kendoDatePicker_range", "inputName" => "DepositDate", "required" => true]);
        $form->addField(["labelText" => "No Rangka", "inputName" => "VINNumber", "inputCol" => 6]);
        $form->addField(["labelText" => "No Mesin", "inputName" => "EngineNumber", "inputCol" => 6]);
    $form->nextColumn();
        $form->addField(["labelText" => "No SPK", "inputName" => "SPKNumber", "inputCol" => 5]);
        $form->addField(["labelText" => "Nama Konsumen", "inputName" => "CustomerName"]);
        $form->addField(["labelText" => "Nama STNK", "inputName" => "STNKName"]);
    $form->endColumn();
?>
