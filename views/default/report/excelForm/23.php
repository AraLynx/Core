<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
    $form->addField(["inputName" => "Field"]);
    $form->addField(["inputName" => "ValueStart"]);             $form->addField(["inputName" => "ValueEnd"]);
    $form->addField(["inputName" => "ReferenceNumber"]);
    $form->addField(["inputName" => "ProgramTypeId"]);          $form->addField(["inputName" => "ProgramTypeName"]);
    $form->addField(["inputName" => "StatusId"]);               $form->addField(["inputName" => "StatusName"]);
?>
