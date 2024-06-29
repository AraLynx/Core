<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
    $form->addField(["inputName" => "DateStart"]);              $form->addField(["inputName" => "DateEnd"]);
    $form->addField(["inputName" => "DivisionId"]);           $form->addField(["inputName" => "DivisionName"]);
    $form->addField(["inputName" => "StatusId"]);               $form->addField(["inputName" => "StatusName"]);

?>
