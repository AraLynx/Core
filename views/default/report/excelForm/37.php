<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
    $form->addField(["inputName" => "GRDateStart"]);      $form->addField(["inputName" => "GRDateEnd"]);
?>