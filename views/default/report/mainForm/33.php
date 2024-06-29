<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
        $form->addField(["labelText" => "Periode Nota", "inputName" => "Date", "inputType" => "kendoDropDownList", "selectTypeDetail" => "monthYearPicker", "selectTemplates" => ["month","year"], "required" => true]);
        $form->addField(["labelText" => "Status PDI", "inputName" => "StatusPDIId", "inputType" => "kendoDropDownList", "selectOptions" => [["PDI & NON PDI","PDI & NON PDI", true],["PDI ONLY","PDI ONLY"],["NON PDI","NON PDI"]], "required" => true]);
?>
