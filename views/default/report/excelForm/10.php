<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
    $form->addColumn(2);
        $form->addField(["inputName" => "VehicleGroupId"]);     $form->addField(["inputName" => "VehicleGroupName"]);
        $form->addField(["inputName" => "VehicleTypeId"]);      $form->addField(["inputName" => "VehicleTypeName"]);
        $form->addField(["inputName" => "UnitColorDescription"]);
        $form->addField(["inputName" => "StatusId"]);           $form->addField(["inputName" => "StatusName"]);
    $form->nextColumn();
        $form->addField(["inputName" => "UnitVIN"]);
        $form->addField(["inputName" => "UnitEngineNumber"]);
        $form->addField(["inputName" => "UnitYear"]);
        $form->addField(["inputName" => "AgeMinimum"]);
    $form->endColumn();
?>
