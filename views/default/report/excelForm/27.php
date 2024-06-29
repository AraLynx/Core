<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
    $form->addField(["inputName" => "CompleteDateStart"]);      $form->addField(["inputName" => "CompleteDateEnd"]);
    $form->addField(["inputName" => "VehicleGroupId"]);         $form->addField(["inputName" => "VehicleGroupName"]);
    $form->addField(["inputName" => "VehicleTypeId"]);          $form->addField(["inputName" => "VehicleTypeName"]);
    $form->addField(["inputName" => "UnitColor"]);
    $form->addField(["inputName" => "UnitEngineNumber"]);
    $form->addField(["inputName" => "UnitVIN"]);
    $form->addField(["inputName" => "UnitYear"]);
    $form->addField(["inputName" => "SalesMethod"]);
?>
