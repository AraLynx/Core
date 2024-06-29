<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
    $form->addField(["inputName" => "DateStart"]);      $form->addField(["inputName" => "DateEnd"]);
?>
