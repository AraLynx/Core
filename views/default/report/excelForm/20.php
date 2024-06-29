<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
    $form->addField(["inputName" => "PeriodeStart"]);       $form->addField(["inputName" => "PeriodeEnd"]);
    $form->addField(["inputName" => "SparepartCode"]);
    $form->addField(["inputName" => "SparepartName"]);

    $dynamicForm = "_{$reportId}Raw_";
    $form->addDynamicForm($dynamicForm);
    $form->addField(["inputName" => "PeriodeStart"]);       $form->addField(["inputName" => "PeriodeEnd"]);
    $form->addField(["inputName" => "SparepartCode"]);
    $form->addField(["inputName" => "SparepartName"]);
?>
