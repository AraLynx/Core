<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
    $form->addField(["inputName" => "LocationPartnerTypeId"]);  $form->addField(["inputName" => "LocationPartnerTypeName"]);
    $form->addField(["inputName" => "LocationPartnerId"]);      $form->addField(["inputName" => "LocationPartnerName"]);
    $form->addField(["inputName" => "StatusId"]);               $form->addField(["inputName" => "StatusName"]);
    $form->addField(["inputName" => "VehicleGroupId"]);         $form->addField(["inputName" => "VehicleGroupName"]);
    $form->addField(["inputName" => "VehicleTypeId"]);          $form->addField(["inputName" => "VehicleTypeName"]);

?>
