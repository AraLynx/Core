<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
        $form->addField(["labelText" => "Periode Nota", "inputName" => "Date", "inputType" => "kendoDropDownList", "selectTypeDetail" => "monthYearPicker", "selectTemplates" => ["month","year"], "required" => true]);
?>
