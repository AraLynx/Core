<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
    $form->addColumn([2,3]);
        $form->addField(["labelIsShow" => false, "inputType" => "kendoDropDownList", "selectFilter" => false, "selectOptions" => $selectOptions["_30_Fields"], "inputName" => "Field", "required" => true]);
    $form->nextColumn();
        $form->addField(["labelIsShow" => false,"inputName" => "Value", "required" => true]);
    $form->endColumn();
?>
