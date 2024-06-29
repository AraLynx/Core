<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
    $form->addField(["inputName" => "ReportVersion"]);
    $form->addField(["inputName" => "DateType"]);
    $form->addField(["inputName" => "DateValueStart"]);                 $form->addField(["inputName" => "DateValueEnd"]);
    $form->addField(["inputName" => "VehicleGroupId"]);                 $form->addField(["inputName" => "VehicleGroupName"]);
    $form->addField(["inputName" => "VehicleTypeId"]);                  $form->addField(["inputName" => "VehicleTypeName"]);
    $form->addField(["inputName" => "UnitColor"]);
    $form->addField(["inputName" => "StatusId"]);                       $form->addField(["inputName" => "StatusName"]);
    $form->addField(["inputName" => "DocumentNumberType"]);             $form->addField(["inputName" => "DocumentNumberValue"]);
    $form->addField(["inputName" => "EmployeeType"]);                   $form->addField(["inputName" => "EmployeeValue"]);
    $form->addField(["inputName" => "CustomerType"]);                   $form->addField(["inputName" => "CustomerValue"]);
?>
