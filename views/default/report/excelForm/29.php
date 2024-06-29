<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
        $form->addField(["inputName" => "VehicleGroupId"]);         $form->addField(["inputName" => "VehicleGroupName"]);
        $form->addField(["inputName" => "VehicleTypeId"]);          $form->addField(["inputName" => "VehicleTypeName"]);
        $form->addField(["inputName" => "ColorDescription"]);
        $form->addField(["inputName" => "EngineNumber"]);
        $form->addField(["inputName" => "VIN"]);
        $form->addField(["inputName" => "Year"]);
        $form->addField(["inputName" => "Age"]);
        $form->addField(["inputName" => "StatusId"]);               $form->addField(["inputName" => "StatusName"]);

?>
