<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
    $form->addColumn([2,4]);
        $form->addField(["labelIsShow" => false, "inputName" => "DateType", "inputType" => "kendoDropDownList", "selectFilter" => false, "selectOptions" => $selectOptions["_42_DateTypes"], "required" => true]);
    $form->nextColumn();
        $form->addField(["labelIsShow" => false, "inputName" => "Date", "inputType" => "kendoDatePicker_range", "required" => true]);
    $form->endColumn();
?>