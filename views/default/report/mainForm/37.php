<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
        $form->addColumn(2);
            $form->addField(["labelText" => "GR Date", "inputName" => "GRDate", "inputType" => "kendoDatePicker_range", "required" => true]);
        $form->nextColumn();
        $form->endColumn();
?>