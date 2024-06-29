<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
    $form->addField(["inputName" => "GRDateStart"]);      $form->addField(["inputName" => "GRDateEnd"]);
    $form->addField(["inputName" => "CaroserieNumber"]);
    $form->addField(["inputName" => "PONumber"]);
    $form->addField(["inputName" => "UnitIdentityType"]);
    $form->addField(["inputName" => "UnitIdentityValue"]);
?>