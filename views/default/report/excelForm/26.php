<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
    $form->addField(["inputName" => "VehicleGroupId"]);         $form->addField(["inputName" => "VehicleGroupName"]);
    $form->addField(["inputName" => "VehicleTypeId"]);          $form->addField(["inputName" => "VehicleTypeName"]);
    $form->addField(["inputName" => "StatusId"]);               $form->addField(["inputName" => "StatusName"]);

?>
