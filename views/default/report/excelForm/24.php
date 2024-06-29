<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
    $form->addField(["inputName" => "DateType"]);
    $form->addField(["inputName" => "NumberType"]);
    $form->addField(["inputName" => "FromType"]);
    $form->addField(["inputName" => "DateStart"]);                  $form->addField(["inputName" => "DateEnd"]);
    $form->addField(["inputName" => "NumberValue"]);
    $form->addField(["inputName" => "FromValue"]);
    $form->addField(["inputName" => "ReferenceTypeId"]);            $form->addField(["inputName" => "ReferenceTypeName"]);
    $form->addField(["inputName" => "MethodId"]);                   $form->addField(["inputName" => "MethodName"]);
    $form->addField(["inputName" => "VehicleGroupId"]);             $form->addField(["inputName" => "VehicleGroupName"]);
    $form->addField(["inputName" => "VehicleTypeId"]);              $form->addField(["inputName" => "VehicleTypeName"]);
    $form->addField(["inputName" => "PICSales"]);
?>
