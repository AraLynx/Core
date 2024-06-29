<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
        $form->addField(["inputName" => "DateStart"]);       $form->addField(["inputName" => "DateEnd"]);
        $form->addField(["inputName" => "SPKNumber"]);
        $form->addField(["inputName" => "DocumentNumber"]);
        $form->addField(["inputName" => "ReferenceNumber"]);
?>
