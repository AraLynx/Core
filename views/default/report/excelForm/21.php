<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
    $form->addField(["inputName" => "ReferenceTypeId"]);
    $form->addField(["inputName" => "InvoiceDateStart"]);
    $form->addField(["inputName" => "InvoiceDateEnd"]);
?>
