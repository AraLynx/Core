<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
    $form->addColumn([2,4,6]);
        $form->addField(["labelIsShow" => false, "inputName" => "Field", "inputType" => "kendoDropDownList", "selectFilter" => false, "selectOptions" => $selectOptions["_23_Types"], "required" => true]);
    $form->nextColumn();
        $form->addField(["labelIsShow" => false, "inputName" => "Value", "inputType" => "kendoDatePicker_range", "required" => true]);
    $form->nextColumn();
        $form->addField(array("labelText" => "Claim Reference", "inputName" => "ReferenceNumber"));
    $form->endColumn();

    $form->addColumn(2);
        $form->addField(["labelText" => "Claim Program", "labelCol" => "4", "inputName" => "ProgramTypeId", "inputType" => "kendoDropDownList", "selectFilter" => false, "selectOptions" => [['*', 'ALL', true]]]);
    $form->nextColumn();
        $form->addField(["labelText" => "Status", "labelCol" => "3", "inputName" => "StatusId", "inputType" => "kendoDropDownList", "selectFilter" => false, "selectOptions" => $selectOptions["_23_Statuses"]]);
    $form->endColumn();
?>
