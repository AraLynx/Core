<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
    $form->addColumn(2);
        $form->addField(["labelText" => "Grup", "inputName" => "VehicleGroupId", "inputType" => "kendoDropDownList", "inputOnChange" => "reportGetReport_VehicleGroupIdChange"]);
        $form->addField(["labelText" => "Tipe", "inputName" => "VehicleTypeId", "inputType" => "kendoDropDownList"]);
        $form->addField(["labelText" => "Warna", "inputName" => "UnitColorDescription"]);
        $form->addField(["labelText" => "Status", "inputName" => "StatusId", "inputType" => "kendoDropDownList", "selectOptions" => $selectOptions["_10_Statuses"]]);
    $form->nextColumn();
        $form->addField(["labelText" => "No Rangka", "inputName" => "UnitVIN"]);
        $form->addField(["labelText" => "No Mesin", "inputName" => "UnitEngineNumber"]);
        $form->addField(["labelText" => "Tahun Rangka", "inputName" => "UnitYear", "inputType" => "kendoNumericTextBox"]);
        $form->addField(["labelText" => "Umur min", "inputName" => "AgeMinimum", "inputType" => "kendoNumericTextBox"]);
    $form->endColumn();
?>
