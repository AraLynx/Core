<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
    $form->addColumn(3);
        $form->addField(["labelText" => "Vehicle Group", "inputType" => "kendoDropDownList", "inputName" => "VehicleGroupId", "inputOnChange" => "reportGetReport_VehicleGroupIdChange"]);
    $form->nextColumn();
        $form->addField(["labelText" => "Vehicle Type", "inputType" => "kendoDropDownList", "inputName" => "VehicleTypeId"]);
    $form->nextColumn();
        $form->addField(["labelText"=>"Status" , "inputName" => "StatusId", "inputType"=>"kendoDropDownList", "inputCol" => 4, "selectOptions"=> $selectOptions["_26_Statuses"] ]);
    $form->endColumn();
?>
