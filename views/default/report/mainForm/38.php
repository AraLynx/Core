<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
        $form->addField(["labelText" => "Period", "inputType" => "kendoDropDownList", "inputName" => "DateApply", "selectTypeDetail" => "monthYearPicker", "selectTemplates" => ["year","month"], "required" => true, "labelCol" => 1, "selectYearMin" => (2024-1), "selectYearMax" => (date("Y")+1)]);
        $form->addField(["labelText" => "Status", "inputType" => "kendoDropDownList", "inputName" => "StatusCode", "selectOptions" => $selectOptions["_38_Statuses"], "inputCol" => 4, "labelCol" => 1]);
        $form->addField(["labelText" => "Doc. Number", "inputName" => "DocumentNumber", "inputCol" => 4, "labelCol" => 1]);
?>