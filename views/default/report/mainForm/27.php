<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
    $form->addColumn(3);
        $form->addField(["labelText" => "Invoice Date", "inputType" => "kendoDatePicker_range", "inputName" => "CompleteDate", "required" => true]);
        $form->addField(["labelText" => "Vehicle Group", "inputType" => "kendoDropDownList", "inputName" => "VehicleGroupId", "inputOnChange" => "reportGetReport_VehicleGroupIdChange"]);
        $form->addField(["labelText" => "Vehicle Type", "inputType" => "kendoDropDownList", "inputName" => "VehicleTypeId"]);
        $form->addField(["labelText" => "Vehicle Color", "inputName" => "UnitColor"]);
    $form->nextColumn();
        $form->addField(["labelText" => "Engine Number", "inputName" => "UnitEngineNumber"]);
        $form->addField(["labelText" => "Chassis Number", "inputName" => "UnitVIN", "inputCol" => 6]);
        $form->addField(["labelText" => "Chassis Year", "inputType" => "kendoDropDownList", "inputName" => "UnitYear", "inputCol" => 3, "selectOptions" => $selectOptions["_27_UnitYears"]]);
        $form->addField(["labelText" => "Sales Method", "inputType" => "kendoDropDownList", "inputName" => "SalesMethod", "inputCol" => 4, "selectOptions" => $selectOptions["_27_SalesMethods"]]);
    $form->endColumn();
?>
