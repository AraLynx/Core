<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
        $form->addColumn(3);
            $form->addField(["labelText" => "Vehicle Group", "inputType" => "kendoDropDownList", "inputName" => "VehicleGroupId", "inputOnChange" => "reportGetReport_VehicleGroupIdChange","inputCol" => 8]);
            $form->addField(["labelText" => "Vehicle Type", "inputType" => "kendoDropDownList", "inputName" => "VehicleTypeId", "inputCol" => 8]);
            $form->addField(["labelText" => "Chassis Year", "inputType" => "kendoDropDownList", "inputName" => "UnitYear", "labelCol" => 3, "inputCol" => 5,"selectOptions"=> $selectOptions["_29_UnitYears"]]);
        $form->nextColumn();
            $form->addField(["labelText" => "Engine Number", "inputName" => "EngineNumber", "labelCol" => 4, "inputCol" => 8]);
            $form->addField(["labelText" => "Chassis Number", "inputName" => "VIN", "labelCol" => 4,"inputCol" => 8]);
            $form->addField(["labelText" => "Vehicle Color", "inputName" => "ColorDescription", "labelCol" => 4,"inputCol" => 6]);
        $form->nextColumn();
            $form->addField(["labelText" => "Status", "inputType" => "kendoDropDownList", "inputName" => "StatusId", "labelCol" => 3, "inputCol" => 8,"selectOptions"=> $selectOptions["_29_Statuses"]]);
        $form->endColumn();
?>
