<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
    $form->addField(["inputName" => "InvoiceDateStart"]);       $form->addField(["inputName" => "InvoiceDateEnd"]);
    $form->addField(["inputName" => "VehicleGroupId"]);   $form->addField(["inputName" => "VehicleGroupName"]);
    $form->addField(["inputName" => "VehicleTypeId"]);    $form->addField(["inputName" => "VehicleTypeName"]);

?>
