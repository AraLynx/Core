<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
        $form->addField(["labelText" => "Cash Receive", "inputType" => "kendoDatePicker_range", "inputName" => "Date", "required" => true]);
        $form->addColumn(2);
            $form->addField(["labelText" => "Division", "inputType" => "kendoDropDownList", "inputName" => "DivisionId", "selectOptions" => $selectOptions["_22_DivisionIds"]]);
        $form->nextColumn();
            $form->addField(["labelText" => "Status", "inputType" => "kendoDropDownList", "inputName" => "StatusId", "selectOptions" => $selectOptions["_22_Statuses"]]);
        $form->endColumn();
?>
